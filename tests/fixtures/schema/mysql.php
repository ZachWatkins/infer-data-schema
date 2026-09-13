<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\MySQLColumnType;
use ZachWatkins\InferDataSchema\Models\SqlColumn;
use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

return new SqlColumnCollection([
    new SqlColumn('bit', MySQLColumnType::Bit->value),
    new SqlColumn('bit_nullable', MySQLColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('tinyint', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unique', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable_unique', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned_nullable', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned_unique', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned_nullable_unique', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unique', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable_unique', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_unique', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable_unique', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_nullable', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unique', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_nullable_unique', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned_nullable', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned_unique', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned_nullable_unique', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int', MySQLColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable', MySQLColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unique', MySQLColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable_unique', MySQLColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned', MySQLColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable', MySQLColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_unique', MySQLColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable_unique', MySQLColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint', MySQLColumnType::BigInt->value),
    new SqlColumn('bigint_nullable', MySQLColumnType::BigInt->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('bigint_unique', MySQLColumnType::BigInt->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_nullable_unique', MySQLColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_unsigned', MySQLColumnType::BigInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable', MySQLColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_unique', MySQLColumnType::BigInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable_unique', MySQLColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal', MySQLColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable', MySQLColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unique', MySQLColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable_unique', MySQLColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned', MySQLColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable', MySQLColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_unique', MySQLColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable_unique', MySQLColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('boolean', MySQLColumnType::Boolean->value),
    new SqlColumn('boolean_nullable', MySQLColumnType::Boolean->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('boolean_unique', MySQLColumnType::Boolean->value),
    new SqlColumn('boolean_nullable_unique', MySQLColumnType::Boolean->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char', MySQLColumnType::Varchar->value),
    new SqlColumn('char_nullable', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('char_nullable_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar', MySQLColumnType::Varchar->value),
    new SqlColumn('varchar_nullable', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('varchar_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar_nullable_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text', MySQLColumnType::Text->value),
    new SqlColumn('text_nullable', MySQLColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('text_unique', MySQLColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text_nullable_unique', MySQLColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date', MySQLColumnType::Date->value),
    new SqlColumn('date_nullable', MySQLColumnType::Date->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('date_unique', MySQLColumnType::Date->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date_nullable_unique', MySQLColumnType::Date->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time', MySQLColumnType::Time->value),
    new SqlColumn('time_nullable', MySQLColumnType::Time->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('time_unique', MySQLColumnType::Time->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time_nullable_unique', MySQLColumnType::Time->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime', MySQLColumnType::DateTime->value),
    new SqlColumn('datetime_nullable', MySQLColumnType::DateTime->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('datetime_unique', MySQLColumnType::DateTime->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime_nullable_unique', MySQLColumnType::DateTime->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json', MySQLColumnType::Varchar->value),
    new SqlColumn('json_nullable', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('json_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json_nullable_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml', MySQLColumnType::Varchar->value),
    new SqlColumn('xml_nullable', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('xml_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml_nullable_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
]);
