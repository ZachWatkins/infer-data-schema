<?php

use Tests\SQL\Fixtures\Build\File\TestCsvFileGenerator;
use Tests\SQL\Fixtures\Build\File\TestHttpFileGenerator;
use Tests\SQL\Fixtures\Build\File\TestJsonFileGenerator;
use Tests\SQL\Fixtures\Build\File\TestXlsxFileGenerator;
use Tests\SQL\Fixtures\Build\File\TestXmlFileGenerator;
use Tests\SQL\Fixtures\Build\MySQLTestDataGenerator;
use Tests\SQL\Fixtures\Build\SQLServerTestDataGenerator;
use Tests\SQL\Fixtures\Build\TestSchemaGenerator;

require_once __DIR__.'/../../../vendor/autoload.php';

$generator = new MySQLTestDataGenerator;
$data = $generator->generate(10);

$csvGenerator = new TestCsvFileGenerator;
$csvGenerator->generate('test_mysql.csv', $data);

$httpGenerator = new TestHttpFileGenerator;
$httpGenerator->generate('test_mysql.http', $data);

$jsonGenerator = new TestJsonFileGenerator;
$jsonGenerator->generate('test_mysql.json', $data);

$xlsxGenerator = new TestXlsxFileGenerator;
$xlsxGenerator->generate('test_mysql.xlsx', $data);

$xmlGenerator = new TestXmlFileGenerator;
$xmlGenerator->generate('test_mysql.xml', $data);

$schemaGenerator = new TestSchemaGenerator;
$schemaGenerator->generateMySQL('test_mysql.json', 'mysql.php');

$generator = new SQLServerTestDataGenerator;
$data = $generator->generate(10);

$csvGenerator = new TestCsvFileGenerator;
$csvGenerator->generate('test_sqlserver.csv', $data);

$httpGenerator = new TestHttpFileGenerator;
$httpGenerator->generate('test_sqlserver.http', $data);

$jsonGenerator = new TestJsonFileGenerator;
$jsonGenerator->generate('test_sqlserver.json', $data);

$xlsxGenerator = new TestXlsxFileGenerator;
$xlsxGenerator->generate('test_sqlserver.xlsx', $data);

$xmlGenerator = new TestXmlFileGenerator;
$xmlGenerator->generate('test_sqlserver.xml', $data);

$schemaGenerator = new TestSchemaGenerator;
$schemaGenerator->generateSQLServer('test_sqlserver.json', 'sqlserver.php');

// $schemaGenerator = new TestSchemaGenerator();
// $schemaGenerator->generateSQLite('test.json', 'sqlite.php');
