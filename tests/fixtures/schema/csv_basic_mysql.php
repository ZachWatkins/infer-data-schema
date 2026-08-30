<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\MySqlColumnType;
use ZachWatkins\InferDataSchema\Models\SqlColumn;
use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

return new SqlColumnCollection([
    new SqlColumn('id', MySqlColumnType::TinyInt->value, [
        ColumnModifier::Unique,
        ColumnModifier::Unsigned,
        ColumnModifier::AutoIncrement,
    ]),
    new SqlColumn('name', MySqlColumnType::Varchar->value, [
        ColumnModifier::Unique,
    ]),
    new SqlColumn('birthday', MySqlColumnType::Date->value, []),
    new SqlColumn('created_at', MySqlColumnType::DateTime->value, []),
    new SqlColumn('accept_terms', MySqlColumnType::Boolean->value, []),
    new SqlColumn('deleted_at', MySqlColumnType::DateTime->value, [
        ColumnModifier::Nullable,
    ]),
]);
