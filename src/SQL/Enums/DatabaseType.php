<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\SQL\Enums;

/**
 * The supported target database engines for SQL column type inference.
 */
enum DatabaseType: string
{
    case SQLite = 'sqlite';
    case MySQL = 'mysql';
    case SQLServer = 'sqlserver';
}
