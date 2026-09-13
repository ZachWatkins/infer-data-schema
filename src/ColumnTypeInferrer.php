<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema;

use ZachWatkins\InferDataSchema\Support\ColumnStats;
use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Enums\MySQLColumnType;
use ZachWatkins\InferDataSchema\Enums\SQLiteColumnType;
use ZachWatkins\InferDataSchema\Enums\SQLServerColumnType;
use ZachWatkins\InferDataSchema\Interfaces\ColumnTypeInferrerInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Models\SqlColumn;
use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

/**
 * Evaluates every value of every column in a stream of rows to infer the safest possible
 * SQL column type and modifiers (nullable, unique, unsigned, auto-incrementing) for a
 * given database engine.
 *
 * This is the single shared inference contract used by every parser in
 * {@see \ZachWatkins\InferDataSchema\Parsers} so that type-selection behavior is
 * identical regardless of the data source format.
 */
final class ColumnTypeInferrer implements ColumnTypeInferrerInterface
{
    public function infer(
        iterable $rows,
        DatabaseType $databaseType = DatabaseType::SQLite,
    ): SqlColumnCollectionInterface {
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

        $collection = new SqlColumnCollection();

        foreach ($order as $column) {
            $columnStats = $stats[$column];

            // A row that never mentioned this column is treated exactly like an
            // explicit null value, so parsers do not need to pre-normalize rows to a
            // consistent superset of keys (e.g. optional fields in JSON/XML documents).
            for ($missing = $totalRows - $columnStats->totalCount; $missing > 0; $missing--) {
                $columnStats->record(null);
            }

            $collection->add(new SqlColumn(
                $column,
                $this->resolveType($columnStats, $databaseType),
                $this->resolveModifiers($columnStats, $databaseType),
            ));
        }

        return $collection;
    }

    /**
     * @return array<int, ColumnModifier>
     */
    private function resolveModifiers(ColumnStats $stats, DatabaseType $databaseType): array
    {
        $modifiers = [];

        if ($stats->isNullable()) {
            $modifiers[] = ColumnModifier::Nullable;
        }

        if ($stats->isUnique()) {
            $modifiers[] = ColumnModifier::Unique;
        }

        if ($stats->isUnsigned()) {
            $type = $this->resolveType($stats, $databaseType);
            switch ($databaseType) {
                case DatabaseType::MySQL:
                    if (!\in_array($type, [MySQLColumnType::Boolean->value, MySQLColumnType::Bit->value])) {
                        $modifiers[] = ColumnModifier::Unsigned;
                    }
                    break;
                case DatabaseType::SQLServer:
                    if ($type !== SQLServerColumnType::Bit->value) {
                        $modifiers[] = ColumnModifier::Unsigned;
                    }
                    break;
                default:
                    $modifiers[] = ColumnModifier::Unsigned;
                    break;
            }
        }

        if ($stats->isAutoIncrement()) {
            $modifiers[] = ColumnModifier::AutoIncrement;
        }

        return $modifiers;
    }

    private function resolveType(ColumnStats $stats, DatabaseType $databaseType): string
    {
        return match ($databaseType) {
            DatabaseType::SQLite => $this->resolveSqliteType($stats)->value,
            DatabaseType::MySQL => $this->resolveMySqlType($stats)->value,
            DatabaseType::SQLServer => $this->resolveSqlServerType($stats)->value,
        };
    }

    private function resolveSqliteType(ColumnStats $stats): SQLiteColumnType
    {
        return match (true) {
            $stats->nonNullSeenCount === 0 => SQLiteColumnType::Text,
            $stats->allBool => SQLiteColumnType::Integer,
            $stats->allInt => SQLiteColumnType::Integer,
            $stats->allNumeric => SQLiteColumnType::Real,
            $stats->allDate => SQLiteColumnType::Text,
            $stats->allDateTime => SQLiteColumnType::Text,
            $stats->allTime => SQLiteColumnType::Text,
            default => SQLiteColumnType::Text,
        };
    }

    private function resolveMySqlType(ColumnStats $stats): MySQLColumnType
    {
        return match (true) {
            $stats->nonNullSeenCount === 0 => MySQLColumnType::Varchar,
            $stats->allBool => MySQLColumnType::Boolean,
            $stats->allInt => $this->resolveMySqlIntegerType($stats),
            $stats->allNumeric => MySQLColumnType::Decimal,
            $stats->allDate => MySQLColumnType::Date,
            $stats->allDateTime => MySQLColumnType::DateTime,
            $stats->allTime => MySQLColumnType::Time,
            $stats->maxStringLength > 255 => MySQLColumnType::Text,
            default => MySQLColumnType::Varchar,
        };
    }

    private function resolveMySqlIntegerType(ColumnStats $stats): MySQLColumnType
    {
        $unsigned = !$stats->hasNegative;
        $max = (int) \max(\abs($stats->minValue), \abs($stats->maxValue));

        return match (true) {
            $unsigned && $max <= 1 => MySQLColumnType::Bit,
            $unsigned && $max <= 255 => MySQLColumnType::TinyInt,
            !$unsigned && $max <= 127 => MySQLColumnType::TinyInt,
            $unsigned && $max <= 65_535 => MySQLColumnType::SmallInt,
            !$unsigned && $max <= 32_768 => MySQLColumnType::SmallInt,
            $unsigned && $max <= 16_777_215 => MySQLColumnType::MediumInt,
            !$unsigned && $max <= 8_388_608 => MySQLColumnType::MediumInt,
            $unsigned && $max <= 4_294_967_295 => MySQLColumnType::Int,
            !$unsigned && $max <= 2_147_483_647 => MySQLColumnType::Int,
            default => MySQLColumnType::BigInt,
        };
    }

    private function resolveSqlServerType(ColumnStats $stats): SQLServerColumnType
    {
        return match (true) {
            $stats->allBool => SQLServerColumnType::Bit,
            $stats->allInt => $this->resolveSqlServerIntegerType($stats),
            $stats->allNumeric => SQLServerColumnType::Decimal,
            $stats->allDate => SQLServerColumnType::Date,
            $stats->allDateTime => SQLServerColumnType::DateTime,
            $stats->allTime => SQLServerColumnType::Time,
            $stats->allStringLengthsSame && $stats->maxStringLength > 0 => SQLServerColumnType::Char,
            default => SQLServerColumnType::Varchar,
        };
    }

    private function resolveSqlServerIntegerType(ColumnStats $stats): SQLServerColumnType
    {
        if ($stats->minValue === 0 && $stats->maxValue === 1) {
            return SQLServerColumnType::Bit;
        }

        // SQL Server has no unsigned integer types; TINYINT is the sole 0-255 exception.
        if (!$stats->hasNegative && $stats->maxValue <= 255) {
            return SQLServerColumnType::TinyInt;
        }

        return match (true) {
            $stats->minValue >= -32_768 && $stats->maxValue <= 32_767 => SQLServerColumnType::SmallInt,
            $stats->minValue >= -2_147_483_648 && $stats->maxValue <= 2_147_483_647 => SQLServerColumnType::Int,
            default => SQLServerColumnType::BigInt,
        };
    }
}
