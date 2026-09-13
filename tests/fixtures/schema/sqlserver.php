<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\SQLServerColumnType;
use ZachWatkins\InferDataSchema\Models\SqlColumn;
use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

return new SqlColumnCollection([
    new SqlColumn('bit', SQLServerColumnType::Bit->value),
    new SqlColumn('bit_nullable', SQLServerColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('tinyint', SQLServerColumnType::TinyInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable', SQLServerColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unique', SQLServerColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable_unique', SQLServerColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unique', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable_unique', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_unique', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable_unique', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int', SQLServerColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable', SQLServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unique', SQLServerColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable_unique', SQLServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned', SQLServerColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable', SQLServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_unique', SQLServerColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable_unique', SQLServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint', SQLServerColumnType::BigInt->value),
    new SqlColumn('bigint_nullable', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('bigint_unique', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_nullable_unique', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_unsigned', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_unique', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable_unique', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unique', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable_unique', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_unique', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable_unique', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('boolean', SQLServerColumnType::Bit->value),
    new SqlColumn('boolean_nullable', SQLServerColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('boolean_unique', SQLServerColumnType::Bit->value),
    new SqlColumn('boolean_nullable_unique', SQLServerColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char', SQLServerColumnType::Char->value),
    new SqlColumn('char_nullable', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('char_nullable_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar', SQLServerColumnType::Varchar->value),
    new SqlColumn('varchar_nullable', SQLServerColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('varchar_unique', SQLServerColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar_nullable_unique', SQLServerColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text', SQLServerColumnType::Char->value),
    new SqlColumn('text_nullable', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('text_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text_nullable_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date', SQLServerColumnType::Date->value),
    new SqlColumn('date_nullable', SQLServerColumnType::Date->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('date_unique', SQLServerColumnType::Date->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date_nullable_unique', SQLServerColumnType::Date->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time', SQLServerColumnType::Time->value),
    new SqlColumn('time_nullable', SQLServerColumnType::Time->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('time_unique', SQLServerColumnType::Time->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time_nullable_unique', SQLServerColumnType::Time->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime', SQLServerColumnType::DateTime->value),
    new SqlColumn('datetime_nullable', SQLServerColumnType::DateTime->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('datetime_unique', SQLServerColumnType::DateTime->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime_nullable_unique', SQLServerColumnType::DateTime->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json', SQLServerColumnType::Char->value),
    new SqlColumn('json_nullable', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('json_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json_nullable_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml', SQLServerColumnType::Char->value),
    new SqlColumn('xml_nullable', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('xml_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml_nullable_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
]);
