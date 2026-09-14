<?php

declare(strict_types=1);

it('generates a blueprint modeel for a given csv file', function () {
    $dataFixture = dirname(__DIR__) . str_replace('/', DIRECTORY_SEPARATOR, '/fixtures/data/test_mysql.csv');

    $parser = new CsvParser();
});
