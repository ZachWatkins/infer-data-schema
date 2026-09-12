<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;
use ZachWatkins\InferDataSchema\Parsers\ExcelParser;

it('parses an excel workbook into an inferred mysql schema', function () {
    $parser = new ExcelParser();
    $actual = $parser->parse(
        dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/test.xlsx'),
        'mysql',
    );
    $expected = require dirname(__DIR__) . str_replace(
        '/',
        DIRECTORY_SEPARATOR,
        '/fixtures/schema/mysql.php'
    );

    expect($actual->count())->toBe($expected->count());

    $actualColumns = $actual->getColumns();
    $expectedColumns = $expected->getColumns();

    foreach ($expectedColumns as $index => $expectedColumn) {
        /** @var SqlColumnInterface|null $actualColumn */
        $actualColumn = $actualColumns[$index] ?? null;

        expect($actualColumn)->not->toBeNull();
        expect($actualColumn->getName())->toBe($expectedColumn->getName());
        expect($actualColumn->getType())->toBe($expectedColumn->getType());
        $expectedModifiers = \array_map(
            static fn(ColumnModifier $modifier): string => $modifier->value,
            $expectedColumn->getModifiers(),
        );
        $actualModifiers = \array_map(
            static fn(ColumnModifier $modifier): string => $modifier->value,
            $actualColumn->getModifiers(),
        );
        expect($actualModifiers)->toBe(
            $expectedModifiers,
            "Mismatch in column modifiers for column: {$actualColumn->getName()}"
        );
    }
});
