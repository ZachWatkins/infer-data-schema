<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Interfaces;

use ZachWatkins\InferDataSchema\Blueprint\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Blueprint\Enums\LaravelColumnType;

/**
 * Represents a single inferred Laravel Shift Blueprint column definition.
 */
interface BlueprintColumnInterface
{
    public function getName(): string;

    /**
     * The Laravel-specific column type value (e.g. `int`, `string`, `decimal`).
     */
    public function getType(): LaravelColumnType;

    /**
     * @return array<int, string>
     */
    public function getAttributes(): array;

    public function hasAttributes(): bool;

    /**
     * @return array<int, ColumnModifier>
     */
    public function getModifiers(): array;

    public function hasModifiers(): bool;

    public function hasModifier(ColumnModifier $modifier): bool;
}
