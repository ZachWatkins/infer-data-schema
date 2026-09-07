<?php

/**
 * Generates test fixture data for the library's parsers and schema inference logic.
 * It ensures test data fixtures have full coverage over supported data formats, databases, database column types, and column modifiers.
 * The HTTP data format will just be a copy of the json data, but use a file name that indicates it is for http responses.
 */

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Enums\MySqlColumnType;
use ZachWatkins\InferDataSchema\Enums\SqliteColumnType;
use ZachWatkins\InferDataSchema\Enums\SqlServerColumnType;

require_once __DIR__ . '../vendor/autoload.php';

$formats = ['csv', 'xlsx', 'json', 'xml', 'http'];
