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
    /**
     * Unsigned range: 0 to 255
     * Signed range: -128 to 127
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/int-bigint-smallint-and-tinyint-transact-sql
     */
    case TinyInt = 'TINYINT';
    /**
     * Unsigned range: 0 to 65,535
     * Signed range: -32,768 to 32,767
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/int-bigint-smallint-and-tinyint-transact-sql
     */
    case SmallInt = 'SMALLINT';
    /**
     * Unsigned range: 0 to 4,294,967,295
     * Signed range: -2,147,483,648 to 2,147,483,647
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/int-bigint-smallint-and-tinyint-transact-sql
     */
    case Int = 'INT';
    /**
     * Unsigned range: 0 to 18,446,744,073,709,551,615
     * Signed range: -9,223,372,036,854,775,808 to 9,223,372,036,854,775,807
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/int-bigint-smallint-and-tinyint-transact-sql
     */
    case BigInt = 'BIGINT';
    /**
     * The declaration syntax for a DECIMAL column is DECIMAL(M,D). The ranges of values for the arguments are as follows:
     * - M is the maximum number of digits (the precision). It has a range of 1 to 65.
     * - D is the number of digits to the right of the decimal point (the scale). It has a range of 0 to 30 and must be no larger than M.
     * @see https://dev.mysql.com/doc/refman/8.4/en/precision-math-decimal-characteristics.html
     */
    case Decimal = 'DECIMAL';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/boolean-literals.html
     */
    case Boolean = 'BOOLEAN';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/date-and-time-literals.html
     */
    case Date = 'DATE';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/date-and-time-literals.html
     */
    case Time = 'TIME';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/date-and-time-literals.html
     */
    case DateTime = 'DATETIME';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/char.html
     */
    case Char = 'CHAR';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/char.html
     */
    case Varchar = 'VARCHAR';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/text.html
     */
    case Text = 'TEXT';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/json.html
     */
    case Json = 'JSON';
}
