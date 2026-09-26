<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\SQL\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnCollectionInterface;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnInterface;
use ZachWatkins\InferDataSchema\SQL\Parsers\CsvParser;
use ZachWatkins\InferDataSchema\SQL\Enums\DatabaseType;

it('infers the expected MySQL schema from CSV basic fixture', function () {
    /** @var SQLColumnCollectionInterface $expected */
    $dataFixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/test_mysql.csv');

    $parser = new CsvParser();
    $normalizeColumns = static function (SQLColumnCollectionInterface $columns): array {
        return array_map(
            static fn(SQLColumnInterface $column): array => [
                'name' => $column->getName(),
                'type' => $column->getType(),
                'modifiers' => array_map(
                    static fn(ColumnModifier $modifier): string => $modifier->value,
                    $column->getModifiers(),
                ),
            ],
            $columns->getColumns(),
        );
    };

    $actual = $parser->parse($dataFixture, DatabaseType::MySQL->value);

    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/mysql.php');

    expect($normalizeColumns($actual))->toBe($normalizeColumns($expected));
})->group('sql');
