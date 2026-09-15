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
        $max = (int) $stats->maxValue;

        if (!$stats->hasNegative) {
            if ($max <= 255) {
                return LaravelColumnType::tinyInteger;
            }
            if ($max <= 65_535) {
                return LaravelColumnType::smallInteger;
            }
            if ($max <= 16_777_215) {
                return LaravelColumnType::mediumInteger;
            }
            $result = bccomp((string) $max, '4294967295');
            if ($result <= 0) {
                return LaravelColumnType::integer;
            }
            return LaravelColumnType::bigInteger;
        }

        $min = (int) \abs($stats->minValue);

        if (-128 <= $min && $max <= 127) {
            return LaravelColumnType::tinyInteger;
        }

        if (-32_768 <= $min && $max <= 32_767) {
            return LaravelColumnType::smallInteger;
        }

        if (-8_388_608 <= $min && $max <= 8_388_607) {
            return LaravelColumnType::mediumInteger;
        }

        $result = bccomp((string) $min, '-2147483648');
        if ($result >= 0) {
            $result = bccomp((string) $max, '2147483647');
            if ($result <= 0) {
                return LaravelColumnType::integer;
            }
        }

        return LaravelColumnType::bigInteger;
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
