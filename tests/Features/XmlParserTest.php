<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;
use ZachWatkins\InferDataSchema\Parsers\XmlParser;

$modifierValuesForXml = static function (SqlColumnInterface $column): array {
    return \array_map(
        static fn (ColumnModifier $modifier): string => $modifier->value,
        $column->getModifiers(),
    );
};

$assertXmlColumnCollectionMatches = static function (
    SqlColumnCollectionInterface $actual,
    SqlColumnCollectionInterface $expected,
) use ($modifierValuesForXml): void {
    expect($actual->count())->toBe($expected->count());

    $actualColumns = $actual->getColumns();
    $expectedColumns = $expected->getColumns();

    foreach ($expectedColumns as $index => $expectedColumn) {
        /** @var SqlColumnInterface|null $actualColumn */
        $actualColumn = $actualColumns[$index] ?? null;

        expect($actualColumn)->not->toBeNull();
        expect($actualColumn->getName())->toBe($expectedColumn->getName());
        expect($actualColumn->getType())->toBe($expectedColumn->getType());
        expect($modifierValuesForXml($actualColumn))->toBe($modifierValuesForXml($expectedColumn));
    }
};

it('parses flat xml rows into an inferred mysql schema', function () use ($assertXmlColumnCollectionMatches) {
    $parser = new XmlParser();
    $actual = $parser->parse(
        dirname(__DIR__) . '\fixtures\data\xml_basic.xml',
        DatabaseType::MySql,
    );
    $expected = require dirname(__DIR__) . '\fixtures\schema\xml_basic_mysql.php';

    $assertXmlColumnCollectionMatches($actual, $expected);
});

it('parses nested xml rows when a node path is configured', function () use ($assertXmlColumnCollectionMatches) {
    $parser = new XmlParser('root/items/item');
    $actual = $parser->parse(
        dirname(__DIR__) . '\fixtures\data\xml_nested.xml',
        DatabaseType::MySql,
    );
    $expected = require dirname(__DIR__) . '\fixtures\schema\xml_basic_mysql.php';

    $assertXmlColumnCollectionMatches($actual, $expected);
});
