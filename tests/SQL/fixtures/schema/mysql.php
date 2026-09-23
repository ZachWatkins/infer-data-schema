<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\SQL\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\SQL\Enums\MySQLColumnType;
use ZachWatkins\InferDataSchema\SQL\Models\SQLColumn;
use ZachWatkins\InferDataSchema\SQL\Models\SQLColumnCollection;

return new SQLColumnCollection([
    new SQLColumn('tinyint', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_nullable', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unique', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_nullable_unique', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unsigned', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unsigned_nullable', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unsigned_unique', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('tinyint_unsigned_nullable_unique', MySQLColumnType::TinyInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_nullable', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unique', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_nullable_unique', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned_nullable', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned_unique', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('smallint_unsigned_nullable_unique', MySQLColumnType::SmallInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_nullable', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unique', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_nullable_unique', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unsigned', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unsigned_nullable', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unsigned_unique', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('mediumint_unsigned_nullable_unique', MySQLColumnType::MediumInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int', MySQLColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_nullable', MySQLColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unique', MySQLColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_nullable_unique', MySQLColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned', MySQLColumnType::Int->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned_nullable', MySQLColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned_unique', MySQLColumnType::Int->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('int_unsigned_nullable_unique', MySQLColumnType::Int->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint', MySQLColumnType::BigInt->value),
    new SQLColumn('bigint_nullable', MySQLColumnType::BigInt->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('bigint_unique', MySQLColumnType::BigInt->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('bigint_nullable_unique', MySQLColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('bigint_unsigned', MySQLColumnType::BigInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint_unsigned_nullable', MySQLColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint_unsigned_unique', MySQLColumnType::BigInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('bigint_unsigned_nullable_unique', MySQLColumnType::BigInt->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal', MySQLColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_nullable', MySQLColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unique', MySQLColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_nullable_unique', MySQLColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned', MySQLColumnType::Decimal->value, [
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned_nullable', MySQLColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned_unique', MySQLColumnType::Decimal->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('decimal_unsigned_nullable_unique', MySQLColumnType::Decimal->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
    ]),
    new SQLColumn('boolean', MySQLColumnType::Boolean->value),
    new SQLColumn('boolean_nullable', MySQLColumnType::Boolean->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('boolean_unique', MySQLColumnType::Boolean->value),
    new SQLColumn('boolean_nullable_unique', MySQLColumnType::Boolean->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('char', MySQLColumnType::Varchar->value),
    new SQLColumn('char_nullable', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('char_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('char_nullable_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('varchar', MySQLColumnType::Varchar->value),
    new SQLColumn('varchar_nullable', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('varchar_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('varchar_nullable_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('text', MySQLColumnType::Text->value),
    new SQLColumn('text_nullable', MySQLColumnType::Text->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('text_unique', MySQLColumnType::Text->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('text_nullable_unique', MySQLColumnType::Text->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('date', MySQLColumnType::Date->value),
    new SQLColumn('date_nullable', MySQLColumnType::Date->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('date_unique', MySQLColumnType::Date->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('date_nullable_unique', MySQLColumnType::Date->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('time', MySQLColumnType::Time->value),
    new SQLColumn('time_nullable', MySQLColumnType::Time->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('time_unique', MySQLColumnType::Time->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('time_nullable_unique', MySQLColumnType::Time->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('datetime', MySQLColumnType::DateTime->value),
    new SQLColumn('datetime_nullable', MySQLColumnType::DateTime->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('datetime_unique', MySQLColumnType::DateTime->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('datetime_nullable_unique', MySQLColumnType::DateTime->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('json', MySQLColumnType::Varchar->value),
    new SQLColumn('json_nullable', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('json_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('json_nullable_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
    new SQLColumn('xml', MySQLColumnType::Varchar->value),
    new SQLColumn('xml_nullable', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
    ]),
    new SQLColumn('xml_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SQLColumn('xml_nullable_unique', MySQLColumnType::Varchar->value, [
        ColumnModifier::Nullable,
        ColumnModifier::Unique,
    ]),
]);
