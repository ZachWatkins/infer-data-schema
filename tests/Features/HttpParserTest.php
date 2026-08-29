<?php

declare(strict_types=1);

use Nyholm\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;
use ZachWatkins\InferDataSchema\Parsers\HttpParser;

$modifierValues = static fn(SqlColumnInterface $column): array => \array_map(
    static fn(ColumnModifier $modifier): string => $modifier->value,
    $column->getModifiers(),
);

$assertSchemaMatchesExpected = static function (
    SqlColumnCollectionInterface $actual,
    SqlColumnCollectionInterface $expected,
) use ($modifierValues): void {
    $actualColumns = $actual->getColumns();
    $expectedColumns = $expected->getColumns();

    expect($actualColumns)->toHaveCount(\count($expectedColumns));

    foreach ($expectedColumns as $index => $expectedColumn) {
        $actualColumn = $actualColumns[$index];

        expect($actualColumn->getName())->toBe($expectedColumn->getName());
        expect($actualColumn->getType())->toBe($expectedColumn->getType());
        expect($modifierValues($actualColumn))->toBe($modifierValues($expectedColumn));
    }
};

it('parses a bare top-level json array response', function () use ($assertSchemaMatchesExpected) {
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/http_basic_mysql.php');

    $client = new class implements ClientInterface {
        public ?RequestInterface $lastRequest = null;

        public function sendRequest(RequestInterface $request): ResponseInterface
        {
            $this->lastRequest = $request;

            return new Response(
                200,
                ['Content-Type' => 'application/json'],
                \json_encode([
                    ['id' => 1, 'name' => 'Norbert'],
                    ['id' => 2, 'name' => 'Norbert'],
                ], JSON_THROW_ON_ERROR),
            );
        }
    };

    $actual = (new HttpParser($client))->parse('https://example.com/users', 'mysql');

    expect($client->lastRequest)->not->toBeNull();
    expect($client->lastRequest->getMethod())->toBe('GET');
    expect($client->lastRequest->getHeaderLine('Accept'))->toBe('application/json');

    $assertSchemaMatchesExpected($actual, $expected);
});

it('parses a wrapped json array response', function () use ($assertSchemaMatchesExpected) {
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/http_basic_mysql.php');

    $client = new class implements ClientInterface {
        public ?RequestInterface $lastRequest = null;

        public function sendRequest(RequestInterface $request): ResponseInterface
        {
            $this->lastRequest = $request;

            return new Response(
                200,
                ['Content-Type' => 'application/json'],
                \json_encode([
                    'items' => [
                        ['id' => 1, 'name' => 'Norbert'],
                        ['id' => 2, 'name' => 'Norbert'],
                    ],
                ], JSON_THROW_ON_ERROR),
            );
        }
    };

    $actual = (new HttpParser($client))->parse('https://example.com/users', 'mysql');

    expect($client->lastRequest)->not->toBeNull();
    expect($client->lastRequest->getMethod())->toBe('GET');
    expect($client->lastRequest->getHeaderLine('Accept'))->toBe('application/json');

    $assertSchemaMatchesExpected($actual, $expected);
});
