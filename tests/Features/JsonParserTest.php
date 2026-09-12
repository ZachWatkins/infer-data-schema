<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;
use ZachWatkins\InferDataSchema\Parsers\JsonParser;

it('infers the expected MySQL schema from JSON basic fixture', function () {
    /** @var SqlColumnCollectionInterface $expected */
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/mysql.php');
    $dataFixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/test.json');
    $parser = new JsonParser();

    $actual = $parser->parse($dataFixture, 'mysql');
    $normalizedActual = array_map(
        static fn(SqlColumnInterface $column): array => [
            'name' => $column->getName(),
            'type' => $column->getType(),
            'modifiers' => array_map(
                static fn(ColumnModifier $modifier): string => $modifier->value,
                $column->getModifiers(),
            ),
        ],
        $actual->getColumns(),
    );
    $normalizedExpected = array_map(
        static fn(SqlColumnInterface $column): array => [
            'name' => $column->getName(),
            'type' => $column->getType(),
            'modifiers' => array_map(
                static fn(ColumnModifier $modifier): string => $modifier->value,
                $column->getModifiers(),
            ),
        ],
        $expected->getColumns(),
    );

    expect($normalizedActual)->toBe($normalizedExpected);
});
