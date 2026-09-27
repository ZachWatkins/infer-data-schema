<?php

declare(strict_types=1);

namespace ZachWatkins\InferLaravelBlueprint\Blueprint\Parsers;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Inferrers\BlueprintColumnTypeInferrer;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Interfaces\BlueprintColumnCollectionInterface;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Interfaces\BlueprintColumnTypeInferrerInterface;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Interfaces\BlueprintParserInterface;

final class HttpParser implements BlueprintParserInterface
{
    private readonly ?BlueprintParserInterface $parser;

    /**
     * @param  list<array{string, string}>  $headers
     */
    public function __construct(
        private readonly ClientInterface $client,
        private readonly BlueprintColumnTypeInferrerInterface $inferrer = new BlueprintColumnTypeInferrer,
        ?BlueprintParserInterface $parser = null,
        private readonly string $sourceExtension = 'json',
        private readonly string $accept = 'application/json',
        private readonly array $headers = [],
    ) {
        $this->parser = $parser;
    }

    public function parse(string $source, string $databaseType = 'sqlite'): BlueprintColumnCollectionInterface
    {
        $request = (new Psr17Factory)
            ->createRequest('GET', $source)
            ->withHeader('Accept', $this->accept);

        $customAcceptHeader = false;
        foreach ($this->headers as [$name, $value]) {
            if (\strcasecmp($name, 'Accept') === 0) {
                $request = $customAcceptHeader
                    ? $request->withAddedHeader($name, $value)
                    : $request->withHeader($name, $value);
                $customAcceptHeader = true;

                continue;
            }

            $request = $request->withAddedHeader($name, $value);
        }

        $response = $this->client->sendRequest($request);
        if ($response->getStatusCode() >= 400) {
            throw new \RuntimeException(\sprintf('HTTP request failed with status code %d.', $response->getStatusCode()));
        }

        $responseBody = $response->getBody();
        if ($responseBody->isSeekable()) {
            $responseBody->rewind();
        }
        $content = $responseBody->getContents();

        if ($this->parser === null) {
            $body = \json_decode($content, true, 512, \JSON_THROW_ON_ERROR);

            return $this->inferrer->infer(\is_array($body) ? $this->extractRecords($body) ?? [] : []);
        }

        $temporaryFile = \tempnam(\sys_get_temp_dir(), 'infer-schema-');
        if ($temporaryFile === false) {
            throw new \RuntimeException('Unable to create a temporary file for the HTTP response.');
        }

        $parserPath = $temporaryFile.'.'.$this->sourceExtension;
        if (! \rename($temporaryFile, $parserPath)) {
            \unlink($temporaryFile);

            throw new \RuntimeException('Unable to prepare a temporary file for the HTTP response.');
        }

        try {
            if (\file_put_contents($parserPath, $content) === false) {
                throw new \RuntimeException('Unable to write the HTTP response to a temporary file.');
            }

            return $this->parser->parse($parserPath);
        } finally {
            if (\file_exists($parserPath)) {
                \unlink($parserPath);
            }
        }
    }

    /**
     * @param  array<mixed>  $body
     * @return list<array<string, mixed>>|null
     */
    private function extractRecords(array $body): ?array
    {
        if ($this->isRecordList($body)) {
            return $body;
        }

        $arrayValues = [];
        foreach ($body as $value) {
            if (\is_array($value)) {
                $arrayValues[] = $value;
            }
        }

        if (\count($arrayValues) !== 1 || ! $this->isRecordList($arrayValues[0])) {
            return null;
        }

        return $arrayValues[0];
    }

    /**
     * @param  array<mixed>  $value
     */
    private function isRecordList(array $value): bool
    {
        if (! \array_is_list($value)) {
            return false;
        }

        foreach ($value as $record) {
            if (! \is_array($record) || \array_is_list($record)) {
                return false;
            }
        }

        return true;
    }
}
