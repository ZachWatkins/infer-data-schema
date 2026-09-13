<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\SQL\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnCollectionInterface;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnInterface;
use ZachWatkins\InferDataSchema\SQL\Parsers\JsonParser;

it('infers the expected MySQL schema from JSON basic fixture', function () {
    /** @var SQLColumnCollectionInterface $expected */
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/mysql.php');
    $dataFixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/test_mysql.json');
    $parser = new JsonParser();

    $actual = $parser->parse($dataFixture, 'mysql');
    $normalizedActual = array_map(
        static fn(SQLColumnInterface $column): array => [
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
        static fn(SQLColumnInterface $column): array => [
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
