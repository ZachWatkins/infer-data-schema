<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\SQL\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\SQL\Enums\SQLServerColumnType;
use ZachWatkins\InferDataSchema\SQL\Models\SQLColumn;
use ZachWatkins\InferDataSchema\SQL\Models\SQLColumnCollection;

return new SQLColumnCollection([
    new SQLColumn('bit', SQLServerColumnType::Bit->value),
    new SQLColumn('bit_nullable', SQLServerColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('tinyint', SQLServerColumnType::TinyInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_nullable', SQLServerColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unique', SQLServerColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_nullable_unique', SQLServerColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_nullable', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unique', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_nullable_unique', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned_nullable', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned_unique', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned_nullable_unique', SQLServerColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int', SQLServerColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_nullable', SQLServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unique', SQLServerColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_nullable_unique', SQLServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned', SQLServerColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned_nullable', SQLServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned_unique', SQLServerColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned_nullable_unique', SQLServerColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint', SQLServerColumnType::BigInt->value),
    new SQLColumn('bigint_nullable', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('bigint_unique', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('bigint_nullable_unique', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('bigint_unsigned', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint_unsigned_nullable', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint_unsigned_unique', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint_unsigned_nullable_unique', SQLServerColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_nullable', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unique', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_nullable_unique', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned_nullable', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned_unique', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned_nullable_unique', SQLServerColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('boolean', SQLServerColumnType::Bit->value),
    new SQLColumn('boolean_nullable', SQLServerColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('boolean_unique', SQLServerColumnType::Bit->value),
    new SQLColumn('boolean_nullable_unique', SQLServerColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('char', SQLServerColumnType::Char->value),
    new SQLColumn('char_nullable', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('char_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('char_nullable_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('varchar', SQLServerColumnType::Varchar->value),
    new SQLColumn('varchar_nullable', SQLServerColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('varchar_unique', SQLServerColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('varchar_nullable_unique', SQLServerColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('text', SQLServerColumnType::Char->value),
    new SQLColumn('text_nullable', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('text_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('text_nullable_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('date', SQLServerColumnType::Date->value),
    new SQLColumn('date_nullable', SQLServerColumnType::Date->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('date_unique', SQLServerColumnType::Date->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('date_nullable_unique', SQLServerColumnType::Date->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('time', SQLServerColumnType::Time->value),
    new SQLColumn('time_nullable', SQLServerColumnType::Time->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('time_unique', SQLServerColumnType::Time->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('time_nullable_unique', SQLServerColumnType::Time->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('datetime', SQLServerColumnType::DateTime->value),
    new SQLColumn('datetime_nullable', SQLServerColumnType::DateTime->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('datetime_unique', SQLServerColumnType::DateTime->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('datetime_nullable_unique', SQLServerColumnType::DateTime->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('json', SQLServerColumnType::Char->value),
    new SQLColumn('json_nullable', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('json_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('json_nullable_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('xml', SQLServerColumnType::Char->value),
    new SQLColumn('xml_nullable', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('xml_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('xml_nullable_unique', SQLServerColumnType::Char->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
]);
