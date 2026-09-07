# Inferring Dates

## Status

Accepted (Last updated: 2026-09-07 10:05:00 CST)

## Context

Dates have many accepted formats. For example, SQL Server accepts the following formats for the [date](https://learn.microsoft.com/en-us/sql/t-sql/data-types/date-transact-sql) column type depending on language and dateformat settings:

- yyyy-MM-dd (default)
- [m]m/dd/[yy]yy
- [m]m-dd-[yy]yy
- [m]m/[yy]yy/dd
- [m]m-[yy]yy-dd
- [m]m.[yy]yy.dd
- dd/[m]m/[yy]yy
- dd-[m]m-[yy]yy
- dd.[m]m.[yy]yy
- dd/[yy]yy/[m]m
- dd-[yy]yy-[m]m
- dd.[yy]yy.[m]m
- [yy]yy/[m]m/dd
- [yy]yy-[m]m-dd
- [yy]yy.[m]m.dd
- [dd] mon[,] yyyy
- dd mon[,][yy]yy
- dd [yy]yy mon
- [dd] yyyy mon
- mon [dd][,] yyyy
- mon dd[,] [yy]
- mon yyyy [dd]
- yyyy mon [dd]
- yyyy [dd] mon
- yyyy [dd] mon
- yyyy-MM-dd
- yyyyMMdd
- [yy]yyMMdd
- yyyy[MMdd]
- yyyy-MM-ddTZD

## Decision

This library will focus on supporting the most commonly used date format: yyyy-MM-dd. Other dates may be supported at a later time but only if they can be supported without requiring additional SQL statements to support their use when creating the table schema.

Other date formats will be inferred as literal strings.

## Consequences

- The library will correctly infer and handle dates in the yyyy-MM-dd format.
- Dates in other formats will be treated as literal strings, which may require additional handling by the user.
