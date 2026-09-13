<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\SQL\Enums;

/**
 * SQLite column types.
 *
 * @see https://www.sqlite.org/datatype3.html
 * @see https://sqlite.org/limits.html
 */
enum SQLiteColumnType: string
{
    case Integer = 'INTEGER';
    case Text = 'TEXT';
    case Real = 'REAL';
    case Numeric = 'NUMERIC';
}
