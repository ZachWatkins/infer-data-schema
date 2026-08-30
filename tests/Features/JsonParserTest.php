<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;
use ZachWatkins\InferDataSchema\Parsers\JsonParser;

it('infers the expected MySQL schema from JSON basic fixture', function () {
    /** @var SqlColumnCollectionInterface $expected */
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/json_basic_mysql.php');
    $dataFixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/json_basic.json');
    $parser = new JsonParser();
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

    $actual = $parser->parse($dataFixture, 'mysql');

    expect($normalizeColumns($actual))->toBe($normalizeColumns($expected));
});

it('infers the expected MySQL schema from JSON nullable fixture', function () {
    /** @var SqlColumnCollectionInterface $expected */
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/json_nullable_mysql.php');
    $dataFixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/json_nullable.json');
    $parser = new JsonParser();
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

    $actual = $parser->parse($dataFixture, 'mysql');

    expect($normalizeColumns($actual))->toBe($normalizeColumns($expected));
});

it('infers the expected MySQL schema from JSON width fixture', function () {
    /** @var SqlColumnCollectionInterface $expected */
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/json_widths_mysql.php');
    $dataFixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/json_widths.json');
    $parser = new JsonParser();
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

    $actual = $parser->parse($dataFixture, 'mysql');

    expect($normalizeColumns($actual))->toBe($normalizeColumns($expected));
});
