<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\MySqlColumnType;
use ZachWatkins\InferDataSchema\Models\SqlColumn;
use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

return new SqlColumnCollection([
    new SqlColumn('bit', MySqlColumnType::Bit->value),
    new SqlColumn('bit_nullable', MySqlColumnType::Bit->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('tinyint', MySqlColumnType::TinyInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable', MySqlColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unique', MySqlColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable_unique', MySqlColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned', MySqlColumnType::TinyInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned_nullable', MySqlColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned_unique', MySqlColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned_nullable_unique', MySqlColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint', MySqlColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable', MySqlColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unique', MySqlColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable_unique', MySqlColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned', MySqlColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable', MySqlColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_unique', MySqlColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable_unique', MySqlColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint', MySqlColumnType::MediumInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_nullable', MySqlColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unique', MySqlColumnType::MediumInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_nullable_unique', MySqlColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned', MySqlColumnType::MediumInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned_nullable', MySqlColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned_unique', MySqlColumnType::MediumInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned_nullable_unique', MySqlColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int', MySqlColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable', MySqlColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unique', MySqlColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable_unique', MySqlColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned', MySqlColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable', MySqlColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_unique', MySqlColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable_unique', MySqlColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint', MySqlColumnType::BigInt->value),
    new SqlColumn('bigint_nullable', MySqlColumnType::BigInt->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('bigint_unique', MySqlColumnType::BigInt->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_nullable_unique', MySqlColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_unsigned', MySqlColumnType::BigInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable', MySqlColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_unique', MySqlColumnType::BigInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable_unique', MySqlColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal', MySqlColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable', MySqlColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unique', MySqlColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable_unique', MySqlColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned', MySqlColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable', MySqlColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_unique', MySqlColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable_unique', MySqlColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('boolean', MySqlColumnType::Boolean->value),
    new SqlColumn('boolean_nullable', MySqlColumnType::Boolean->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('boolean_unique', MySqlColumnType::Boolean->value),
    new SqlColumn('boolean_nullable_unique', MySqlColumnType::Boolean->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char', MySqlColumnType::Varchar->value),
    new SqlColumn('char_nullable', MySqlColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char_unique', MySqlColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('char_nullable_unique', MySqlColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar', MySqlColumnType::Varchar->value),
    new SqlColumn('varchar_nullable', MySqlColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('varchar_unique', MySqlColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar_nullable_unique', MySqlColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text', MySqlColumnType::Text->value),
    new SqlColumn('text_nullable', MySqlColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('text_unique', MySqlColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text_nullable_unique', MySqlColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date', MySqlColumnType::Date->value),
    new SqlColumn('date_nullable', MySqlColumnType::Date->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('date_unique', MySqlColumnType::Date->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date_nullable_unique', MySqlColumnType::Date->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time', MySqlColumnType::Time->value),
    new SqlColumn('time_nullable', MySqlColumnType::Time->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('time_unique', MySqlColumnType::Time->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time_nullable_unique', MySqlColumnType::Time->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime', MySqlColumnType::DateTime->value),
    new SqlColumn('datetime_nullable', MySqlColumnType::DateTime->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('datetime_unique', MySqlColumnType::DateTime->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime_nullable_unique', MySqlColumnType::DateTime->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json', MySqlColumnType::Varchar->value),
    new SqlColumn('json_nullable', MySqlColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('json_unique', MySqlColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json_nullable_unique', MySqlColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml', MySqlColumnType::Varchar->value),
    new SqlColumn('xml_nullable', MySqlColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('xml_unique', MySqlColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml_nullable_unique', MySqlColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
]);
