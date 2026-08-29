<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Enums;

/**
 * SQLite column types (storage classes and common type affinities).
 *
 * @see https://www.sqlite.org/datatype3.html
 */
enum SqliteColumnType: string
{
    case Integer = 'INTEGER';
    case Real = 'REAL';
    case Numeric = 'NUMERIC';
    case Text = 'TEXT';
    case Blob = 'BLOB';
    case Boolean = 'BOOLEAN';
    case Date = 'DATE';
    case DateTime = 'DATETIME';
    case Time = 'TIME';
}
