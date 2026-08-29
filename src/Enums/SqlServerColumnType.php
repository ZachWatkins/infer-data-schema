<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Enums;

/**
 * SQL Server (Transact-SQL) column types commonly used for schema inference.
 *
 * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/data-types-transact-sql
 */
enum SqlServerColumnType: string
{
    case Bit = 'BIT';
    case TinyInt = 'TINYINT';
    case SmallInt = 'SMALLINT';
    case Int = 'INT';
    case BigInt = 'BIGINT';
    case Decimal = 'DECIMAL';
    case Float = 'FLOAT';
    case Date = 'DATE';
    case DateTime2 = 'DATETIME2';
    case Time = 'TIME';
    case Varchar = 'VARCHAR';
    case NVarchar = 'NVARCHAR';
    case Text = 'TEXT';
    case VarBinary = 'VARBINARY';
    case UniqueIdentifier = 'UNIQUEIDENTIFIER';
}
