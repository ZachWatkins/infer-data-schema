<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\MySqlColumnType;
use ZachWatkins\InferDataSchema\Models\SqlColumn;
use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

return new SqlColumnCollection([
    new SqlColumn('item_id', MySqlColumnType::SmallInt->value, [
        ColumnModifier::Unsigned,
    ]),
    new SqlColumn('bio', MySqlColumnType::Text->value),
    new SqlColumn('postal_code', MySqlColumnType::Varchar->value),
]);
