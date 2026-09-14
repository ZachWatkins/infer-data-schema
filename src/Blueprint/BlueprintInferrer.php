<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema;

use ZachWatkins\InferDataSchema\SQL\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Models\Blueprint;
use ZachWatkins\InferDataSchema\Models\BlueprintColumnCollection;
use ZachWatkins\InferDataSchema\Support\ColumnStats;
use ZachWatkins\InferDataSchema\SQL\Enums\ColumnModifier;

/**
 * This class accepts a ColumnStats object and returns a Blueprint model which can be used to render a Laravel Shift Blueprint YAML file.
 * Steps:
 * 1. Iterate over the data rows to create ColumnStats objects.
 * 2. Use the ColumnStats objects to infer the blueprint columns.
 * 3. Return a Blueprint model containing the inferred columns.
 */
class BlueprintInferrer
{
    /**
     * @param iterable<array<string, mixed>> $rows Each row is an associative array keyed by column name.
     */
    public function infer(
        iterable $rows,
        DatabaseType $databaseType = DatabaseType::SQLite,
    ): Blueprint {
        /** @var array<string, ColumnStats> $stats */
        $stats = [];
        /** @var array<int, string> $order */
        $order = [];
        $totalRows = 0;

        foreach ($rows as $row) {
            $totalRows++;

            foreach ($row as $column => $value) {
                if (!isset($stats[$column])) {
                    $stats[$column] = new ColumnStats();
                    $order[] = $column;
                }

                $stats[$column]->record($value);
            }
        }

        $collection = new BlueprintColumnCollection();

        foreach ($order as $column) {
            $columnStats = $stats[$column];

            // A row that never mentioned this column is treated exactly like an
            // explicit null value, so parsers do not need to pre-normalize rows to a
            // consistent superset of keys (e.g. optional fields in JSON/XML documents).
            for ($missing = $totalRows - $columnStats->totalCount; $missing > 0; $missing--) {
                $columnStats->record(null);
            }

            $collection->add(new SQLColumn(
                $column,
                $this->resolveType($columnStats, $databaseType),
                $this->resolveModifiers($columnStats, $databaseType),
            ));
        }
    }
}
