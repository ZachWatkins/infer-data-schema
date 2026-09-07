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
    /**
     * The bit data type is used for storing Boolean values as 0, 1, or NULL.
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/bit-transact-sql
     */
    case Bit = 'BIT';
    /**
     * Range: 0 to 255
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/int-bigint-smallint-and-tinyint-transact-sql
     */
    case TinyInt = 'TINYINT';
    /**
     * Range: -32,768 to 32,767
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/int-bigint-smallint-and-tinyint-transact-sql
     */
    case SmallInt = 'SMALLINT';
    /**
     * Range: -2,147,483,648 to 2,147,483,647
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/int-bigint-smallint-and-tinyint-transact-sql
     */
    case Int = 'INT';
    /**
     * Range: -9,223,372,036,854,775,808 to 9,223,372,036,854,775,807
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/int-bigint-smallint-and-tinyint-transact-sql
     */
    case BigInt = 'BIGINT';
    /**
     * Decimal values in SQL Server.
     * Min value: -10^38 + 1
     * Max value: 10^38 - 1
     * Min precision: 1
     * Max precision: 38
     * Min scale: 0
     * Max scale: 38 (must be less than or equal to the precision)
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/decimal-and-numeric-transact-sql
     */
    case Decimal = 'DECIMAL';
    /**
     * Range: 0001-01-01 to 9999-12-31.
     * Format: yyyy-MM-dd
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/date-transact-sql
     */
    case Date = 'DATE';
    /**
     * Range:
     * 00:00:00.0000000 through 23:59:59.9999999
     * Accepted formats:
     * hh:mm[:ss][:fractional seconds][AM][PM]
     * hh:mm[:ss][.fractional seconds][AM][PM]
     * hhAM[PM]
     * hh AM[PM]
     * hh:mm:ss
     * hh:mm[:ss][.fractional seconds]
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/time-transact-sql
     */
    case Time = 'TIME';
    /**
     * The setting for SET DATEFORMAT determines how date values are interpreted by SQL Server.
     * Date range:
     * 1753-01-01 (January 1, 1753) through 9999-12-31 (December 31, 9999)
     * Time range:
     * 00:00:00 through 23:59:59.997
     * Accuracy:
     * Rounded to increments of .000, .003, or .007 seconds
     * Accepted formats:
     * yyyy-MM-ddTHH:mm:ss[.mmm]
     * yyyyMMdd[ HH:mm:ss[.mmm]]
     * yyyyMMdd HH:mm:ss[.mmm]
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/datetime-transact-sql
     */
    case DateTime = 'DATETIME';
    /**
     * "Fixed-size string data. n defines the string size in bytes and must be a value from 1 through 8,000. For single-byte encoding character sets such as Latin, the storage size is n bytes and the number of characters that can be stored is also n. For multibyte encoding character sets, the storage size is still n bytes but the number of characters that can be stored might be smaller than n. The ISO synonym for char is character. For more information on character sets, see Single-Byte and Multibyte Character Sets. [...] A common misconception is to think that with char(n) and varchar(n), the n defines the number of characters. However, in char(n) and varchar(n), the n defines the string length in bytes (0 to 8,000). n never defines numbers of characters that can be stored. This concept is similar to the definition of nchar and nvarchar. [...] Use char when the sizes of the column data entries are consistent."
     * This means the amount of bytes will need to be calculated when inferring whether this column type should be used for a database column.
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/char-and-varchar-transact-sql
     */
    case Char = 'CHAR';
    /**
     * "Variable-size string data. Use n to define the string size in bytes and can be a value from 1 through 8,000, or use max to indicate a column constraint size up to a maximum storage of 2^31-1 bytes (2 GB) or 1 MB in Fabric Data Warehouse. For single-byte encoding character sets such as Latin, the storage size is n bytes + 2 bytes and the number of characters that can be stored is also n. For multibyte encoding character sets, the storage size is still n bytes + 2 bytes but the number of characters that can be stored might be smaller than n. The ISO synonyms for varchar are char varying or character varying. For more information on character sets, see Single-Byte and Multibyte Character Sets. [...] A common misconception is to think that with char(n) and varchar(n), the n defines the number of characters. However, in char(n) and varchar(n), the n defines the string length in bytes (0 to 8,000). n never defines numbers of characters that can be stored. This concept is similar to the definition of nchar and nvarchar. [...] Use varchar when the sizes of the column data entries vary considerably. Use varchar(max) when the sizes of the column data entries vary considerably, and the string length might exceed 8,000 bytes."
     * This means the amount of bytes will need to be calculated when inferring whether this column type should be used for a database column.
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/char-and-varchar-transact-sql
     */
    case Varchar = 'VARCHAR';
    /**
     * nchar [ ( n ) ]
     * "Fixed-size string data. n defines the string size in byte-pairs, and must be a value from 1 through 4,000. The storage size is two times n bytes. For UCS-2 encoding, the storage size is two times n bytes and the number of characters that can be stored is also n. For UTF-16 encoding, the storage size is still two times n bytes, but the number of characters that can be stored might be smaller than n, because Supplementary Characters use two byte-pairs (also called surrogate pairs). The ISO synonyms for nchar are national char and national character."
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/nchar-and-nvarchar-transact-sql
     */
    case NChar = 'NCHAR';
    /**
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/nchar-and-nvarchar-transact-sql
     */
    case NVarchar = 'NVARCHAR';
    /**
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/varbinary-transact-sql
     */
    case VarBinary = 'VARBINARY';
    /**
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/json-data-type
     */
    case Json = 'JSON';
    /**
     * @see https://learn.microsoft.com/en-us/sql/t-sql/xml/xml-transact-sql
     */
    case XML = 'XML';
}
