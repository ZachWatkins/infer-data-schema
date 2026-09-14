<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint;

use ZachWatkins\InferDataSchema\Support\ColumnStats;
use ZachWatkins\InferDataSchema\Blueprint\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Blueprint\Enums\LaravelColumnType;
use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintColumnTypeInferrerInterface;
use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintColumn;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintColumnCollection;

/**
 * Evaluates every value of every column in a stream of rows to infer the safest possible
 * SQL column type and modifiers (nullable, unique, unsigned, auto-incrementing) for a
 * given database engine.
 *
 * This is the single shared inference contract used by every parser in
 * {@see \ZachWatkins\InferDataSchema\Parsers} so that type-selection behavior is
 * identical regardless of the data source format.
 */
final class BlueprintColumnTypeInferrer implements BlueprintColumnTypeInferrerInterface
{
    public function infer(
        iterable $rows,
    ): BlueprintColumnCollectionInterface {
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

            $collection->add(new BlueprintColumn(
                $column,
                $this->resolveType($columnStats),
                $this->resolveModifiers($columnStats),
            ));
        }

        return $collection;
    }

    /**
     * @return array<int, ColumnModifier>
     */
    private function resolveModifiers(ColumnStats $stats): array
    {
        $modifiers = [];

        if ($stats->isNullable()) {
            $modifiers[] = ColumnModifier::Nullable;
        }

        if ($stats->isUnique()) {
            $modifiers[] = ColumnModifier::Unique;
        }

        if ($stats->isUnsigned()) {
            if ($stats->allInt) {
                $modifiers[] = ColumnModifier::Unsigned;
            }
        }

        if ($stats->isAutoIncrement()) {
            $modifiers[] = ColumnModifier::AutoIncrement;
        }

        return $modifiers;
    }

    private function resolveType(ColumnStats $stats): LaravelColumnType
    {
        return match (true) {
            $stats->allBool => LaravelColumnType::boolean,
            $stats->allInt => $this->resolveIntegerType($stats),
            $stats->allNumeric => LaravelColumnType::decimal,
            $stats->allDate => LaravelColumnType::date,
            $stats->allDateTime => LaravelColumnType::dateTime,
            $stats->allTime => LaravelColumnType::time,
            default => $this->resolveStringType($stats),
        };
    }

    private function resolveIntegerType(ColumnStats $stats): LaravelColumnType
    {
        $unsigned = !$stats->hasNegative;
        $max = (int) \max(\abs($stats->minValue), \abs($stats->maxValue));

        return match (true) {
            $unsigned && $max <= 1 => LaravelColumnType::Bit,
            $unsigned && $max <= 255 => LaravelColumnType::TinyInt,
            !$unsigned && $max <= 127 => LaravelColumnType::TinyInt,
            $unsigned && $max <= 65_535 => LaravelColumnType::SmallInt,
            !$unsigned && $max <= 32_768 => LaravelColumnType::SmallInt,
            $unsigned && $max <= 16_777_215 => LaravelColumnType::MediumInt,
            !$unsigned && $max <= 8_388_608 => LaravelColumnType::MediumInt,
            $unsigned && $max <= 4_294_967_295 => LaravelColumnType::Int,
            !$unsigned && $max <= 2_147_483_647 => LaravelColumnType::Int,
            default => LaravelColumnType::BigInt,
        };
    }

    private function resolveStringType(ColumnStats $stats): LaravelColumnType
    {
        // Resolve char, longText, mediumText, string, text, tinyText, json, macAddress, ipAddress, uuid, ulid.
        if ($stats->allStringLengthsSame && $stats->maxStringLength <= 255) {
            return LaravelColumnType::char;
        }

        if ($stats->maxStringLength <= 255) {
            return LaravelColumnType::tinyText;
        }

        $maximumBytes = $stats->maxStringByteLength();

        if ($maximumBytes <= 65_535) {
            return LaravelColumnType::string;
        }

        if ($stats->maxStringLength <= 65_535) {
            return LaravelColumnType::text;
        }

        if ($stats->maxStringLength <= 16_777_215) {
            return LaravelColumnType::mediumText;
        }

        return LaravelColumnType::longText;
    }
}
