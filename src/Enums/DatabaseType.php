<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Enums;

/**
 * The supported target database engines for SQL column type inference.
 */
enum DatabaseType: string
{
    case Sqlite = 'sqlite';
    case MySql = 'mysql';
    case SqlServer = 'sqlserver';
}
