<?php

use Tests\Fixtures\Build\MySQLTestDataGenerator;
use Tests\Fixtures\Build\TestSchemaGenerator;
use Tests\Fixtures\Build\File\TestCsvFileGenerator;
use Tests\Fixtures\Build\File\TestHttpFileGenerator;
use Tests\Fixtures\Build\File\TestJsonFileGenerator;
use Tests\Fixtures\Build\File\TestXlsxFileGenerator;
use Tests\Fixtures\Build\File\TestXmlFileGenerator;

require_once __DIR__ . '/../../vendor/autoload.php';

$generator = new MySQLTestDataGenerator();
$data = $generator->generate(10);

$csvGenerator = new TestCsvFileGenerator();
$csvGenerator->generate('test_mysql.csv', $data);

$httpGenerator = new TestHttpFileGenerator();
$httpGenerator->generate('test_mysql.http', $data);

$jsonGenerator = new TestJsonFileGenerator();
$jsonGenerator->generate('test_mysql.json', $data);

$xlsxGenerator = new TestXlsxFileGenerator();
$xlsxGenerator->generate('test_mysql.xlsx', $data);

$xmlGenerator = new TestXmlFileGenerator();
$xmlGenerator->generate('test_mysql.xml', $data);

$schemaGenerator = new TestSchemaGenerator();
$schemaGenerator->generateMySql('test_mysql.json', 'mysql.php');

$schemaGenerator = new TestSchemaGenerator();
$schemaGenerator->generateSqlServer('test_sqlserver.json', 'sqlserver.php');

// $schemaGenerator = new TestSchemaGenerator();
// $schemaGenerator->generateSqlite('test.json', 'sqlite.php');
