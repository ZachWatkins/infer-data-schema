<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\SqliteColumnType;
use ZachWatkins\InferDataSchema\Models\SqlColumn;
use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

return new SqlColumnCollection([
    new SqlColumn('bit', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bit_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('tinyint_unsigned_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('smallint_unsigned_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('mediumint_unsigned_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('int_unsigned_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint', SqliteColumnType::Integer->value),
    new SqlColumn('bigint_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('bigint_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('bigint_unsigned', SqliteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bigint_unsigned_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal', SqliteColumnType::Real->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable', SqliteColumnType::Real->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unique', SqliteColumnType::Real->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_nullable_unique', SqliteColumnType::Real->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned', SqliteColumnType::Real->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable', SqliteColumnType::Real->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_unique', SqliteColumnType::Real->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('decimal_unsigned_nullable_unique', SqliteColumnType::Real->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('boolean', SqliteColumnType::Integer->value),
    new SqlColumn('boolean_nullable', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('boolean_unique', SqliteColumnType::Integer->value),
    new SqlColumn('boolean_nullable_unique', SqliteColumnType::Integer->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char', SqliteColumnType::Text->value),
    new SqlColumn('char_nullable', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('char_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('char_nullable_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar', SqliteColumnType::Text->value),
    new SqlColumn('varchar_nullable', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('varchar_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('varchar_nullable_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text', SqliteColumnType::Text->value),
    new SqlColumn('text_nullable', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('text_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('text_nullable_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date', SqliteColumnType::Text->value),
    new SqlColumn('date_nullable', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('date_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('date_nullable_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time', SqliteColumnType::Text->value),
    new SqlColumn('time_nullable', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('time_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('time_nullable_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime', SqliteColumnType::Text->value),
    new SqlColumn('datetime_nullable', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('datetime_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('datetime_nullable_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json', SqliteColumnType::Text->value),
    new SqlColumn('json_nullable', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('json_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('json_nullable_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml', SqliteColumnType::Text->value),
    new SqlColumn('xml_nullable', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SqlColumn('xml_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('xml_nullable_unique', SqliteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
]);
