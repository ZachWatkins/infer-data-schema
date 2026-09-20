<?php

use Tests\Fixtures\Build\MySQLTestDataGenerator;
use Tests\Fixtures\Build\SQLServerTestDataGenerator;
use Tests\Fixtures\Build\TestSchemaGenerator;
use Tests\Fixtures\Build\TestBlueprintGenerator;
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
$schemaGenerator->generateMySQL('test_mysql.json', 'mysql.php');

$generator = new SQLServerTestDataGenerator();
$data = $generator->generate(10);

$csvGenerator = new TestCsvFileGenerator();
$csvGenerator->generate('test_sqlserver.csv', $data);

$httpGenerator = new TestHttpFileGenerator();
$httpGenerator->generate('test_sqlserver.http', $data);

$jsonGenerator = new TestJsonFileGenerator();
$jsonGenerator->generate('test_sqlserver.json', $data);

$xlsxGenerator = new TestXlsxFileGenerator();
$xlsxGenerator->generate('test_sqlserver.xlsx', $data);

$xmlGenerator = new TestXmlFileGenerator();
$xmlGenerator->generate('test_sqlserver.xml', $data);

$schemaGenerator = new TestSchemaGenerator();
$schemaGenerator->generateSQLServer('test_sqlserver.json', 'sqlserver.php');

// $schemaGenerator = new TestSchemaGenerator();
// $schemaGenerator->generateSQLite('test.json', 'sqlite.php');

// Blueprint package.
$blueprintGenerator = new TestBlueprintGenerator();
$blueprintGenerator->generate('test_mysql.json', 'test_mysql.yaml');
