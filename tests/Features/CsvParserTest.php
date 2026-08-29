<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;
use ZachWatkins\InferDataSchema\Parsers\CsvParser;

it('infers the expected MySQL schema from CSV basic fixture', function () {
    $dataFixture = 'csv_basic.csv';
    $schemaFixture = 'csv_basic_mysql.php';
    $parser = new CsvParser();
    $normalizeColumns = static function (SqlColumnCollectionInterface $columns): array {
        return array_map(
            static fn(SqlColumnInterface $column): array => [
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

    $actual = $parser->parse(dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/' . $dataFixture));

    /** @var SqlColumnCollectionInterface $expected */
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/' . $schemaFixture);

    expect($normalizeColumns($actual))->toBe($normalizeColumns($expected));
});

it('infers the expected MySQL schema from CSV nullable fixture', function () {
    $dataFixture = 'csv_nullable.csv';
    $schemaFixture = 'csv_nullable_mysql.php';
    $parser = new CsvParser();
    $normalizeColumns = static function (SqlColumnCollectionInterface $columns): array {
        return array_map(
            static fn(SqlColumnInterface $column): array => [
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

    $actual = $parser->parse(dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/' . $dataFixture));

    /** @var SqlColumnCollectionInterface $expected */
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/' . $schemaFixture);

    expect($normalizeColumns($actual))->toBe($normalizeColumns($expected));
});

it('infers the expected MySQL schema from CSV width fixture', function () {
    $dataFixture = 'csv_widths.csv';
    $schemaFixture = 'csv_widths_mysql.php';
    $parser = new CsvParser();
    $normalizeColumns = static function (SqlColumnCollectionInterface $columns): array {
        return array_map(
            static fn(SqlColumnInterface $column): array => [
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

    $actual = $parser->parse(dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/' . $dataFixture));

    /** @var SqlColumnCollectionInterface $expected */
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/' . $schemaFixture);

    expect($normalizeColumns($actual))->toBe($normalizeColumns($expected));
});
