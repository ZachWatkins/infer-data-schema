<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Blueprint\Parsers\CsvParser;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintModel;
use ZachWatkins\InferDataSchema\Blueprint\Lexers\BlueprintFileLexer;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintConfig;
use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintColumnCollectionInterface;

it('infers the expected Blueprint columns from the MySQL CSV fixture', function () {
    /** @var BlueprintColumnCollectionInterface $expected */
    $dataFixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/../fixtures/data/test_mysql.csv');

    $parser = new CsvParser();
    $columns = $parser->parse($dataFixture);
    $model = new BlueprintModel('Data', $columns);
    $config = new BlueprintConfig(
        models: [$model],
        view: 'blade',
        resources: ['web'],
        methods: [],
        seeders: true
    );
    $lexer = new BlueprintFileLexer();
    $output = $lexer->toString($config);
    $fixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/../fixtures/blueprint/test_mysql.yaml');
    expect($output)->toBeString();
    expect($output)->toContain(file_get_contents($fixture));
});
