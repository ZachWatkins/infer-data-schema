<?php

declare(strict_types=1);

use Nyholm\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ZachWatkins\InferLaravelBlueprint\SQL\Enums\ColumnModifier;
use ZachWatkins\InferLaravelBlueprint\SQL\Parsers\HttpParser;

it('parses a bare top-level json array response', function () {
    $expected = require dirname(__DIR__).str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/mysql.php');

    $client = new class implements ClientInterface
    {
        public ?RequestInterface $lastRequest = null;

        public function sendRequest(RequestInterface $request): ResponseInterface
        {
            $this->lastRequest = $request;
            $contents = file_get_contents(__DIR__.'/../fixtures/data/test_mysql.http');

            return new Response(
                200,
                ['Content-Type' => 'application/json'],
                $contents
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
            \array_map(static fn (ColumnModifier $modifier): string => $modifier->value, $actualColumn->getModifiers())
        )->toBe(
            \array_map(static fn (ColumnModifier $modifier): string => $modifier->value, $expectedColumn->getModifiers())
        );
    }
})->group('sql');

it('parses a wrapped json array response', function () {
    $expected = require dirname(__DIR__).str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/mysql.php');

    $client = new class implements ClientInterface
    {
        public ?RequestInterface $lastRequest = null;

        public function sendRequest(RequestInterface $request): ResponseInterface
        {
            $this->lastRequest = $request;
            $contents = file_get_contents(__DIR__.'/../fixtures/data/test_mysql.http');

            return new Response(
                200,
                ['Content-Type' => 'application/json'],
                $contents
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
            \array_map(static fn (ColumnModifier $modifier): string => $modifier->value, $actualColumn->getModifiers())
        )->toBe(
            \array_map(static fn (ColumnModifier $modifier): string => $modifier->value, $expectedColumn->getModifiers())
        );
    }
})->group('sql');

it('rejects URL userinfo before sending an HTTP request', function () {
    $client = new class implements ClientInterface
    {
        public int $requestCount = 0;

        public function sendRequest(RequestInterface $request): ResponseInterface
        {
            $this->requestCount++;

            return new Response(200, ['Content-Type' => 'application/json'], '[]');
        }
    };

    expect(fn () => (new HttpParser($client))->parse('https://user:secret@example.com/users', 'mysql'))
        ->toThrow(InvalidArgumentException::class, 'HTTP URLs must not contain userinfo credentials.');
    expect($client->requestCount)->toBe(0);
})->group('sql');
