<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Support;

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Enums\MySqlColumnType;
use ZachWatkins\InferDataSchema\Enums\SqliteColumnType;
use ZachWatkins\InferDataSchema\Enums\SqlServerColumnType;
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
        DatabaseType $databaseType = DatabaseType::Sqlite,
    ): SqlColumnCollectionInterface {
        /** @var array<string, ColumnStats> $stats */
        $stats = [];
        /** @var array<int, string> $order */
        $order = [];

        foreach ($rows as $row) {
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
            $collection->add(new SqlColumn(
                $column,
                $this->resolveType($stats[$column], $databaseType),
                $this->resolveModifiers($stats[$column]),
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
            $modifiers[] = ColumnModifier::Unsigned;
        }

        if ($stats->isAutoIncrement()) {
            $modifiers[] = ColumnModifier::AutoIncrement;
        }

        return $modifiers;
    }

    private function resolveType(ColumnStats $stats, DatabaseType $databaseType): string
    {
        return match ($databaseType) {
            DatabaseType::Sqlite => $this->resolveSqliteType($stats)->value,
            DatabaseType::MySql => $this->resolveMySqlType($stats)->value,
            DatabaseType::SqlServer => $this->resolveSqlServerType($stats)->value,
        };
    }

    private function resolveSqliteType(ColumnStats $stats): SqliteColumnType
    {
        return match (true) {
            $stats->nonNullSeenCount === 0 => SqliteColumnType::Text,
            $stats->allBool => SqliteColumnType::Boolean,
            $stats->allInt => SqliteColumnType::Integer,
            $stats->allNumeric => SqliteColumnType::Real,
            $stats->allDate => SqliteColumnType::Date,
            $stats->allDateTime => SqliteColumnType::DateTime,
            $stats->allTime => SqliteColumnType::Time,
            default => SqliteColumnType::Text,
        };
    }

    private function resolveMySqlType(ColumnStats $stats): MySqlColumnType
    {
        return match (true) {
            $stats->nonNullSeenCount === 0 => MySqlColumnType::Varchar,
            $stats->allBool => MySqlColumnType::Boolean,
            $stats->allInt => $this->resolveMySqlIntegerType($stats),
            $stats->allNumeric => MySqlColumnType::Decimal,
            $stats->allDate => MySqlColumnType::Date,
            $stats->allDateTime => MySqlColumnType::DateTime,
            $stats->allTime => MySqlColumnType::Time,
            $stats->maxStringLength > 255 => MySqlColumnType::Text,
            default => MySqlColumnType::Varchar,
        };
    }

    private function resolveMySqlIntegerType(ColumnStats $stats): MySqlColumnType
    {
        $unsigned = !$stats->hasNegative;
        $max = (int) \max(\abs($stats->minValue), \abs($stats->maxValue));

        return match (true) {
            $unsigned && $max <= 255 => MySqlColumnType::TinyInt,
            !$unsigned && $max <= 128 => MySqlColumnType::TinyInt,
            $unsigned && $max <= 65_535 => MySqlColumnType::SmallInt,
            !$unsigned && $max <= 32_768 => MySqlColumnType::SmallInt,
            $unsigned && $max <= 16_777_215 => MySqlColumnType::MediumInt,
            !$unsigned && $max <= 8_388_608 => MySqlColumnType::MediumInt,
            $unsigned && $max <= 4_294_967_295 => MySqlColumnType::Int,
            !$unsigned && $max <= 2_147_483_648 => MySqlColumnType::Int,
            default => MySqlColumnType::BigInt,
        };
    }

    private function resolveSqlServerType(ColumnStats $stats): SqlServerColumnType
    {
        return match (true) {
            $stats->nonNullSeenCount === 0 => SqlServerColumnType::Varchar,
            $stats->allBool => SqlServerColumnType::Bit,
            $stats->allInt => $this->resolveSqlServerIntegerType($stats),
            $stats->allNumeric => SqlServerColumnType::Decimal,
            $stats->allDate => SqlServerColumnType::Date,
            $stats->allDateTime => SqlServerColumnType::DateTime2,
            $stats->allTime => SqlServerColumnType::Time,
            $stats->maxStringLength > 4_000 => SqlServerColumnType::Text,
            default => SqlServerColumnType::Varchar,
        };
    }

    private function resolveSqlServerIntegerType(ColumnStats $stats): SqlServerColumnType
    {
        // SQL Server has no unsigned integer types; TINYINT is the sole 0-255 exception.
        if (!$stats->hasNegative && $stats->maxValue <= 255) {
            return SqlServerColumnType::TinyInt;
        }

        return match (true) {
            $stats->minValue >= -32_768 && $stats->maxValue <= 32_767 => SqlServerColumnType::SmallInt,
            $stats->minValue >= -2_147_483_648 && $stats->maxValue <= 2_147_483_647 => SqlServerColumnType::Int,
            default => SqlServerColumnType::BigInt,
        };
    }
}
