<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;
use ZachWatkins\InferDataSchema\Parsers\CsvParser;

it('infers the expected MySQL schema from CSV basic fixture', function () {
    /** @var SqlColumnCollectionInterface $expected */
    $dataFixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/test.csv');

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

    $actual = $parser->parse($dataFixture, 'mysql');

    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/mysql.php');

    expect($normalizeColumns($actual))->toBe($normalizeColumns($expected));
});
