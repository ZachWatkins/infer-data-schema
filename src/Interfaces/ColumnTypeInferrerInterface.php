<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Interfaces;

use ZachWatkins\InferDataSchema\Enums\DatabaseType;

/**
 * Infers a {@see SqlColumnCollectionInterface} from a stream of data rows.
 *
 * Implementations must evaluate every row for every column in order to determine
 * the safest possible SQL column type and modifiers (nullable, unique, unsigned,
 * auto-incrementing).
 */
interface ColumnTypeInferrerInterface
{
    /**
     * @param iterable<array<string, mixed>> $rows Each row is an associative array keyed by column name.
     */
    public function infer(
        iterable $rows,
        DatabaseType $databaseType = DatabaseType::Sqlite,
    ): SqlColumnCollectionInterface;
}
