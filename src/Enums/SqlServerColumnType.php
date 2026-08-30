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
     */
    case Decimal = 'DECIMAL';
    /**
     * Approximate floating-point values in SQL Server.
     * Range: -1.79E+308 to -2.23E-308, 0 and 2.23E-308 to 1.79E+308
     */
    case Float = 'FLOAT';
    /**
     * Approximate floating-point values in SQL Server with lower precision than FLOAT.
     * Range: -3.40E+38 to -1.18E-38, 0 and 1.18E-38 to 3.40E+38
     */
    case Real = 'REAL';
    /**
     * Range: 0001-01-01 to 9999-12-31.
     * The current language setting determines the default date format. You can change the date format by using the SET LANGUAGE and SET DATEFORMAT statements.
     * Default format: yyyy-MM-dd
     * Accepted formats:
     * SET DATEFORMAT mdy;
     * [m]m/dd/[yy]yy
     * [m]m-dd-[yy]yy
     * SET DATEFORMAT myd;
     * [m]m/[yy]yy/dd
     * [m]m-[yy]yy-dd
     * [m]m.[yy]yy.dd
     * SET DATEFORMAT dmy;
     * dd/[m]m/[yy]yy
     * dd-[m]m-[yy]yy
     * dd.[m]m.[yy]yy
     * SET DATEFORMAT dym;
     * dd/[yy]yy/[m]m
     * dd-[yy]yy-[m]m
     * dd.[yy]yy.[m]m
     * SET DATEFORMAT ymd;
     * [yy]yy/[m]m/dd
     * [yy]yy-[m]m-dd
     * [yy]yy.[m]m.dd
     * Alphabetical list of formats (mon represents the full month name, or the month abbreviation, given in the current language. Commas are optional and capitalization is ignored. If the day is missing, the first day of the month is supplied.)
     * [dd] mon[,] yyyy
     * dd mon[,][yy]yy
     * dd [yy]yy mon
     * [dd] yyyy mon
     * mon [dd][,] yyyy
     * mon dd[,] [yy]
     * mon yyyy [dd]
     * yyyy mon [dd]
     * yyyy [dd] mon
     * yyyy [dd] mon
     * ISO 8601 list of formats
     * yyyy-MM-dd
     * yyyyMMdd
     * Unseparated list of formats (The date data can be specified with four, six, or eight digits. A six-digit or eight-digit string is always interpreted as ymd. The month and day must always be two digits. A four-digit string is interpreted as the year.)
     * [yy]yyMMdd
     * yyyy[MMdd]
     * W3C XML date format (Supported for XML/SOAP usage. TZD is the time zone designator (Z or +hh:mm or -hh:mm): (1) hh:mm represents the time zone offset. hh is two digits, ranging from 0 to 14, which represent the number of hours in the time zone offset. (2) mm is two digits, ranging from 0 to 59, which represent the number of additional minutes in the time zone offset. (3) + (plus) or - (minus) is the mandatory sign of the time zone offset. This sign indicates that, to obtain the local time, the time zone offset is added or subtracted from the Coordinated Universal Times (UTC) time. The valid range of time zone offset is from -14:00 to +14:00.)
     * yyyy-MM-ddTZD
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
     * Date range:
     * 0001-01-01 through 9999-12-31
     * Time range:
     * 00:00:00 through 23:59:59.9999999
     * Accepted formats:
     * yyyy-MM-dd HH:mm:ss[.nnnnnnn]
     * yyyy-MM-ddTHH:mm:ss[.nnnnnnn]
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/datetime2-transact-sql
     */
    case DateTime2 = 'DATETIME2';
    /**
     * Date range:
     * 0001-01-01 through 9999-12-31
     * Time range:
     * 00:00:00 through 23:59:59.9999999
     * Time zone offset range:
     * -14:00 through +14:00
     * Accepted formats:
     * yyyy-MM-dd HH:mm:ss[.nnnnnnn] [{+|-}hh:mm]
     * yyyy-MM-ddTHH:mm:ss[.nnnnnnn][{+|-}hh:mm] (These two formats aren't affected by the SET LANGUAGE and SET DATEFORMAT session locale settings. Spaces aren't allowed between the datetimeoffset and the datetime parts.)
     * yyyy-MM-ddTHH:mm:ss[.nnnnnnn]Z (This format by ISO definition indicates the datetime portion should be expressed in Coordinated Universal Time (UTC). For example, 1999-12-12 12:30:30.12345 -07:00 should be represented as 1999-12-12 19:30:30.12345Z.)
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/datetimeoffset-transact-sql
     */
    case DateTimeOffset = 'DATETIMEOFFSET';
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
     * "A common misconception is to think that with char(n) and varchar(n), the n defines the number of characters. However, in char(n) and varchar(n), the n defines the string length in bytes (0 to 8,000). n never defines numbers of characters that can be stored. This concept is similar to the definition of nchar and nvarchar. [...] Use char when the sizes of the column data entries are consistent."
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/char-transact-sql
     */
    case Char = 'CHAR';
    /**
     * "A common misconception is to think that with char(n) and varchar(n), the n defines the number of characters. However, in char(n) and varchar(n), the n defines the string length in bytes (0 to 8,000). n never defines numbers of characters that can be stored. This concept is similar to the definition of nchar and nvarchar. [...] Use varchar when the sizes of the column data entries vary considerably. Use varchar(max) when the sizes of the column data entries vary considerably, and the string length might exceed 8,000 bytes."
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/varchar-transact-sql
     */
    case Varchar = 'VARCHAR';
    /**
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
    /**
     * @deprecated The ntext, text, and image data types will be removed in a future version of SQL Server. Avoid using these data types in new development work, and plan to modify applications that currently use them. Use nvarchar(max), varchar(max), and varbinary(max) instead.
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/ntext-text-and-image-transact-sql
     */
    case Text = 'TEXT';
    /**
     * @deprecated The ntext, text, and image data types will be removed in a future version of SQL Server. Avoid using these data types in new development work, and plan to modify applications that currently use them. Use nvarchar(max), varchar(max), and varbinary(max) instead.
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/ntext-text-and-image-transact-sql
     */
    case NText = 'NTEXT';
    /**
     * @deprecated The ntext, text, and image data types will be removed in a future version of SQL Server. Avoid using these data types in new development work, and plan to modify applications that currently use them. Use nvarchar(max), varchar(max), and varbinary(max) instead.
     * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/ntext-text-and-image-transact-sql
     */
    case Image = 'IMAGE';
}
