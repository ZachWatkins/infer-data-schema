<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\SqlServerColumnType;
use ZachWatkins\InferDataSchema\Models\SqlColumn;
use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

return new SqlColumnCollection([
    new SqlColumn('bit', SqlServerColumnType::Bit->value),
    new SqlColumn('bit_nullable', SqlServerColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('tinyint', SqlServerColumnType::TinyInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable', SqlServerColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unique', SqlServerColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable_unique', SqlServerColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint', SqlServerColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable', SqlServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unique', SqlServerColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable_unique', SqlServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned', SqlServerColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable', SqlServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_unique', SqlServerColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable_unique', SqlServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int', SqlServerColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable', SqlServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unique', SqlServerColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable_unique', SqlServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned', SqlServerColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable', SqlServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_unique', SqlServerColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable_unique', SqlServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint', SqlServerColumnType::BigInt->value),
    new SqlColumn('bigint_nullable', SqlServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('bigint_unique', SqlServerColumnType::BigInt->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_nullable_unique', SqlServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_unsigned', SqlServerColumnType::BigInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable', SqlServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_unique', SqlServerColumnType::BigInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable_unique', SqlServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal', SqlServerColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable', SqlServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unique', SqlServerColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable_unique', SqlServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned', SqlServerColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable', SqlServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_unique', SqlServerColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable_unique', SqlServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('boolean', SqlServerColumnType::Bit->value),
    new SqlColumn('boolean_nullable', SqlServerColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('boolean_unique', SqlServerColumnType::Bit->value),
    new SqlColumn('boolean_nullable_unique', SqlServerColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char', SqlServerColumnType::Char->value),
    new SqlColumn('char_nullable', SqlServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char_unique', SqlServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('char_nullable_unique', SqlServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar', SqlServerColumnType::Varchar->value),
    new SqlColumn('varchar_nullable', SqlServerColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('varchar_unique', SqlServerColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar_nullable_unique', SqlServerColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text', SqlServerColumnType::Char->value),
    new SqlColumn('text_nullable', SqlServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('text_unique', SqlServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text_nullable_unique', SqlServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date', SqlServerColumnType::Date->value),
    new SqlColumn('date_nullable', SqlServerColumnType::Date->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('date_unique', SqlServerColumnType::Date->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date_nullable_unique', SqlServerColumnType::Date->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time', SqlServerColumnType::Time->value),
    new SqlColumn('time_nullable', SqlServerColumnType::Time->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('time_unique', SqlServerColumnType::Time->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time_nullable_unique', SqlServerColumnType::Time->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime', SqlServerColumnType::DateTime->value),
    new SqlColumn('datetime_nullable', SqlServerColumnType::DateTime->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('datetime_unique', SqlServerColumnType::DateTime->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime_nullable_unique', SqlServerColumnType::DateTime->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json', SqlServerColumnType::Char->value),
    new SqlColumn('json_nullable', SqlServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('json_unique', SqlServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json_nullable_unique', SqlServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml', SqlServerColumnType::Char->value),
    new SqlColumn('xml_nullable', SqlServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('xml_unique', SqlServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml_nullable_unique', SqlServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
]);
