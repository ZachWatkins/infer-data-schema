<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Parsers;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use ZachWatkins\InferDataSchema\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Interfaces\ColumnTypeInferrerInterface;
use ZachWatkins\InferDataSchema\Interfaces\ParserInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Support\ColumnTypeInferrer;

use function Flow\ETL\Adapter\Http\from_static_http_requests;
use function Flow\ETL\DSL\data_frame;

final class HttpParser implements ParserInterface
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly ColumnTypeInferrerInterface $inferrer = new ColumnTypeInferrer(),
    ) {
    }

    public function parse(
        string $source,
        DatabaseType $databaseType = DatabaseType::Sqlite,
    ): SqlColumnCollectionInterface {
        $request = (new Psr17Factory())
            ->createRequest('GET', $source)
            ->withHeader('Accept', 'application/json');

        $rows = data_frame()
            ->read(from_static_http_requests($this->client, $this->requests($request)))
            ->getEachAsArray();

        return $this->inferrer->infer($this->flatten($rows), $databaseType);
    }

    /**
     * Supports the same narrow scope as the file-based parsers: a flat list of flat records.
     *
     * This extracts only `response_body` from Flow's HTTP meta rows and accepts either:
     * - a top-level list of associative-array records, or
     * - an associative wrapper with exactly one array-valued key containing that list.
     *
     * @param iterable<array<string, mixed>> $rows
     *
     * @return \Generator<array<string, mixed>>
     */
    private function flatten(iterable $rows): \Generator
    {
        foreach ($rows as $row) {
            $body = $row['response_body'] ?? null;

            if (!\is_array($body)) {
                continue;
            }

            $records = $this->extractRecords($body);

            if ($records === null) {
                continue;
            }

            foreach ($records as $record) {
                if ($this->isRecord($record)) {
                    yield $record;
                }
            }
        }
    }

    /**
     * @param array<mixed> $body
     *
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

        if (\count($arrayValues) !== 1 || !$this->isRecordList($arrayValues[0])) {
            return null;
        }

        return $arrayValues[0];
    }

    /**
     * @param array<mixed> $value
     */
    private function isRecordList(array $value): bool
    {
        if (!\array_is_list($value)) {
            return false;
        }

        foreach ($value as $record) {
            if (!$this->isRecord($record)) {
                return false;
            }
        }

        return true;
    }

    private function isRecord(mixed $value): bool
    {
        return \is_array($value) && !\array_is_list($value);
    }

    /**
     * @return \Generator<RequestInterface>
     */
    private function requests(RequestInterface $request): \Generator
    {
        yield $request;
    }
}
