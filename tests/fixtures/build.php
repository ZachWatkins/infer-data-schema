<?php

use Tests\Fixtures\Build\TestDataGenerator;
use Tests\Fixtures\Build\TestSchemaGenerator;
use Tests\Fixtures\Build\File\TestCsvFileGenerator;
use Tests\Fixtures\Build\File\TestHttpFileGenerator;
use Tests\Fixtures\Build\File\TestJsonFileGenerator;
use Tests\Fixtures\Build\File\TestXlsxFileGenerator;
use Tests\Fixtures\Build\File\TestXmlFileGenerator;

require_once __DIR__ . '/../../vendor/autoload.php';

$generator = new TestDataGenerator();
$data = $generator->generate(10);

$csvGenerator = new TestCsvFileGenerator();
$csvGenerator->generate('test.csv', $data);

$httpGenerator = new TestHttpFileGenerator();
$httpGenerator->generate('test.http', $data);

$jsonGenerator = new TestJsonFileGenerator();
$jsonGenerator->generate('test.json', $data);

$xlsxGenerator = new TestXlsxFileGenerator();
$xlsxGenerator->generate('test.xlsx', $data);

$xmlGenerator = new TestXmlFileGenerator();
$xmlGenerator->generate('test.xml', $data);

$schemaGenerator = new TestSchemaGenerator();
$schemaGenerator->generateMySql('test.json', 'mysql.php');
