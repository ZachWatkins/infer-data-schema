<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\SQL\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\SQL\Enums\SQLiteColumnType;
use ZachWatkins\InferDataSchema\Models\SQLColumn;
use ZachWatkins\InferDataSchema\Models\SQLColumnCollection;

return new SQLColumnCollection([
    new SQLColumn('bit', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bit_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unsigned', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unsigned_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unsigned_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unsigned_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unsigned', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unsigned_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unsigned_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unsigned_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint', SQLiteColumnType::Integer->value),
    new SQLColumn('bigint_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('bigint_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('bigint_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('bigint_unsigned', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint_unsigned_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint_unsigned_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint_unsigned_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal', SQLiteColumnType::Real->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_nullable', SQLiteColumnType::Real->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unique', SQLiteColumnType::Real->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_nullable_unique', SQLiteColumnType::Real->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned', SQLiteColumnType::Real->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned_nullable', SQLiteColumnType::Real->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned_unique', SQLiteColumnType::Real->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned_nullable_unique', SQLiteColumnType::Real->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('boolean', SQLiteColumnType::Integer->value),
    new SQLColumn('boolean_nullable', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('boolean_unique', SQLiteColumnType::Integer->value),
    new SQLColumn('boolean_nullable_unique', SQLiteColumnType::Integer->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('char', SQLiteColumnType::Text->value),
    new SQLColumn('char_nullable', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('char_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('char_nullable_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('varchar', SQLiteColumnType::Text->value),
    new SQLColumn('varchar_nullable', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('varchar_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('varchar_nullable_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('text', SQLiteColumnType::Text->value),
    new SQLColumn('text_nullable', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('text_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('text_nullable_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('date', SQLiteColumnType::Text->value),
    new SQLColumn('date_nullable', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('date_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('date_nullable_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('time', SQLiteColumnType::Text->value),
    new SQLColumn('time_nullable', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('time_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('time_nullable_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('datetime', SQLiteColumnType::Text->value),
    new SQLColumn('datetime_nullable', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('datetime_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('datetime_nullable_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('json', SQLiteColumnType::Text->value),
    new SQLColumn('json_nullable', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('json_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('json_nullable_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('xml', SQLiteColumnType::Text->value),
    new SQLColumn('xml_nullable', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('xml_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('xml_nullable_unique', SQLiteColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
]);
