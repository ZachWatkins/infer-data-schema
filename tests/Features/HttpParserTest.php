<?php

declare(strict_types=1);

use Nyholm\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Parsers\HttpParser;

it('parses a bare top-level json array response', function () {
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

    $actualColumns = $actual->getColumns();
    $expectedColumns = $expected->getColumns();

    expect($actualColumns)->toHaveCount(\count($expectedColumns));

    foreach ($expectedColumns as $index => $expectedColumn) {
        $actualColumn = $actualColumns[$index];

        expect($actualColumn->getName())->toBe($expectedColumn->getName());
        expect($actualColumn->getType())->toBe($expectedColumn->getType());
        expect(
            \array_map(static fn(ColumnModifier $modifier): string => $modifier->value, $actualColumn->getModifiers())
        )->toBe(
            \array_map(static fn(ColumnModifier $modifier): string => $modifier->value, $expectedColumn->getModifiers())
        );
    }
});

it('parses a wrapped json array response', function () {
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

    $actualColumns = $actual->getColumns();
    $expectedColumns = $expected->getColumns();

    expect($actualColumns)->toHaveCount(\count($expectedColumns));

    foreach ($expectedColumns as $index => $expectedColumn) {
        $actualColumn = $actualColumns[$index];

        expect($actualColumn->getName())->toBe($expectedColumn->getName());
        expect($actualColumn->getType())->toBe($expectedColumn->getType());
        expect(
            \array_map(static fn(ColumnModifier $modifier): string => $modifier->value, $actualColumn->getModifiers())
        )->toBe(
            \array_map(static fn(ColumnModifier $modifier): string => $modifier->value, $expectedColumn->getModifiers())
        );
    }
});
