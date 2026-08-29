<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Interfaces;

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;

/**
 * Represents a single inferred SQL column definition.
 */
interface SqlColumnInterface
{
    public function getName(): string;

    /**
     * The database-specific SQL column type value (e.g. `INT`, `VARCHAR`, `TEXT`).
     */
    public function getType(): string;

    /**
     * @return array<int, ColumnModifier>
     */
    public function getModifiers(): array;

    public function hasModifier(ColumnModifier $modifier): bool;
}
