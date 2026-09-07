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
     * @see https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
     */
    case TinyInt = 'TINYINT';
    /**
     * Unsigned range: 0 to 65,535
     * Signed range: -32,768 to 32,767
     * @see https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
     */
    case SmallInt = 'SMALLINT';
    /**
     * Unsigned range: 0 to 4,294,967,295
     * Signed range: -2,147,483,648 to 2,147,483,647
     * @see https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
     */
    case Int = 'INT';
    /**
     * Unsigned range: 0 to 16,777,215
     * Signed range: -8,388,608 to 8,388,607
     * @see https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
     */
    case MediumInt = 'MEDIUMINT';
    /**
     * Unsigned range: 0 to 18,446,744,073,709,551,615
     * Signed range: -9,223,372,036,854,775,808 to 9,223,372,036,854,775,807
     * @see https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
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
     * @see https://dev.mysql.com/doc/refman/8.0/en/datetime.html
     */
    case Date = 'DATE';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/datetime.html
     */
    case Time = 'TIME';
    /**
     * @see https://dev.mysql.com/doc/refman/8.0/en/datetime.html
     */
    case DateTime = 'DATETIME';
    /**
     * "The length of a CHAR column is fixed to the length that you declare when you create the table. The length can be any value from 0 to 255. When CHAR values are stored, they are right-padded with spaces to the specified length. When CHAR values are retrieved, trailing spaces are removed unless the PAD_CHAR_TO_FULL_LENGTH SQL mode is enabled."
     * @see https://dev.mysql.com/doc/refman/8.0/en/char.html
     */
    case Char = 'CHAR';
    /**
     * "Values in VARCHAR columns are variable-length strings. The length can be specified as a value from 0 to 65,535. The effective maximum length of a VARCHAR is subject to the maximum row size (65,535 bytes, which is shared among all columns) and the character set used. See Section 10.4.7, “Limits on Table Column Count and Row Size”."
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
