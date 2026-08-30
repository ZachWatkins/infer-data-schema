# Inferring Decimals

## Status

Accepted (Last updated: 2026-08-29 21:25:00 CST)

## Context

According to [ISO 754 - IEEE Standard for Floating-Point Arithmetic](https://standards.ieee.org/ieee/754/6210/), floating-point arithmetic can introduce rounding errors. Floating-point data types which a database provider declares as an approximate numeric data type can lead to precision loss in calculations. Decimal data types which a database provider declares as an exact numeric type are safer for financial and other precision-sensitive calculations.

Here is an excerpt from [float and real (Transact-SQL)](https://learn.microsoft.com/en-us/sql/t-sql/data-types/float-and-real-transact-sql):

> Approximate numeric data types don't store the exact values specified for many numbers; they store a close approximation of the value. For some applications, the tiny difference between the specified value and the stored approximation isn't relevant. For others though, the difference is important. Because of the approximate nature of the float and real data types, don't use these data types when exact numeric behavior is required. Examples that require precise numeric values are financial or business data, operations involving rounding, or equality checks. In those cases, use the integer, decimal, numeric, money, or smallmoney data types.

This excerpt from [money and smallmoney (Transact-SQL)](https://learn.microsoft.com/en-us/sql/t-sql/data-types/money-and-smallmoney-transact-sql) indicates a risk when using the `money` and `smallmoney` data types in SQL Server:

> You can experience rounding errors through truncation, when storing monetary values as money and smallmoney. Avoid using this data type if your money or currency values are used in calculations. Instead, use the decimal data type with at least four decimal places.

Floating-point data types which use approximate values are typically recommended for situations where speed is critical and exact decimal precision is less important.

This library cannot infer the purpose of the data it processes, and in this case the desired data type cannot be determined solely by the minimum and maximum values, signing, and floating point length.

## Decision

This library will infer numeric values with decimal points using the database provider's recommended data type for precise decimal values first. If the value is longer or higher than the precise data type can accommodate, it will fall back to using the approximate floating-point data type if it can contain the value.

This library will not infer `money` or `smallmoney` data types for SQL Server. Instead, it will follow the decision described above.

## Consequences

By not using floating-point data types for numeric values containing a decimal point, the library's default behavior potentially slows down calculations involved with that data. However, this approach reduces the risk of introducing rounding errors in calculations.

By not inferring `money` or `smallmoney` data types, the library avoids potentially introducing rounding errors in financial calculations.

If users wish, they can use the library to override this decision by creating their own `SqlColumnCollection` instance using the one returned by the `ParserInterface` instance, and then replacing any column in it as they see fit.
