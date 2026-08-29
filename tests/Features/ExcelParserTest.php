<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;
use ZachWatkins\InferDataSchema\Parsers\ExcelParser;

$modifierValuesForExcel = static function (SqlColumnInterface $column): array {
    return \array_map(
        static fn(ColumnModifier $modifier): string => $modifier->value,
        $column->getModifiers(),
    );
};

$assertExcelColumnCollectionMatches = static function (
    SqlColumnCollectionInterface $actual,
    SqlColumnCollectionInterface $expected,
) use ($modifierValuesForExcel): void {
    expect($actual->count())->toBe($expected->count());

    $actualColumns = $actual->getColumns();
    $expectedColumns = $expected->getColumns();

    foreach ($expectedColumns as $index => $expectedColumn) {
        /** @var SqlColumnInterface|null $actualColumn */
        $actualColumn = $actualColumns[$index] ?? null;

        expect($actualColumn)->not->toBeNull();
        expect($actualColumn->getName())->toBe($expectedColumn->getName());
        expect($actualColumn->getType())->toBe($expectedColumn->getType());
        expect($modifierValuesForExcel($actualColumn))->toBe($modifierValuesForExcel($expectedColumn));
    }
};

it('parses an excel workbook into an inferred mysql schema', function () use ($assertExcelColumnCollectionMatches) {
    $parser = new ExcelParser();
    $actual = $parser->parse(
        dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/excel_basic.xlsx'),
        'mysql',
    );
    $expected = require dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/schema/excel_basic_mysql.php');

    $assertExcelColumnCollectionMatches($actual, $expected);
});
