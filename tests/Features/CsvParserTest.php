<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;
use ZachWatkins\InferDataSchema\Parsers\CsvParser;

it('infers the expected MySQL schema from CSV fixtures', function (string $dataFixture, string $schemaFixture) {
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

    $actual = $parser->parse(__DIR__ . '\\..\\fixtures\\data\\' . $dataFixture, 'mysql');

    /** @var SqlColumnCollectionInterface $expected */
    $expected = require __DIR__ . '\\..\\fixtures\\schema\\' . $schemaFixture;

    expect($normalizeColumns($actual))->toBe($normalizeColumns($expected));
})->with([
    'basic happy path' => ['csv_basic.csv', 'csv_basic_mysql.php'],
    'nullable column' => ['csv_nullable.csv', 'csv_nullable_mysql.php'],
    'integer and string width choices' => ['csv_widths.csv', 'csv_widths_mysql.php'],
]);
