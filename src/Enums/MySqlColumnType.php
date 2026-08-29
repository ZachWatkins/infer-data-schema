<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Enums;

/**
 * MySQL column types commonly used for schema inference.
 *
 * @see https://dev.mysql.com/doc/refman/8.0/en/data-types.html
 */
enum MySqlColumnType: string
{
    case TinyInt = 'TINYINT';
    case SmallInt = 'SMALLINT';
    case MediumInt = 'MEDIUMINT';
    case Int = 'INT';
    case BigInt = 'BIGINT';
    case Decimal = 'DECIMAL';
    case Float = 'FLOAT';
    case Double = 'DOUBLE';
    case Boolean = 'BOOLEAN';
    case Date = 'DATE';
    case DateTime = 'DATETIME';
    case Time = 'TIME';
    case Varchar = 'VARCHAR';
    case Text = 'TEXT';
    case Json = 'JSON';
    case Blob = 'BLOB';
}
