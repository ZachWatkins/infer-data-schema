<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Models;

use ZachWatkins\InferDataSchema\Blueprint\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Blueprint\Enums\LaravelColumnType;
use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintColumnInterface;

/**
 * An immutable representation of a single inferred SQL column.
 */
final class BlueprintColumn implements BlueprintColumnInterface
{
    /**
     * @param array<int, ColumnModifier> $modifiers
     */
    public function __construct(
        private readonly string $name,
        private readonly LaravelColumnType $type,
        private readonly array $attributes = [],
        private readonly array $modifiers = [],
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): LaravelColumnType
    {
        return $this->type;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function hasAttributes(): bool
    {
        return !empty($this->attributes);
    }

    /**
     * @return array<int, ColumnModifier>
     */
    public function getModifiers(): array
    {
        return $this->modifiers;
    }

    public function hasModifiers(): bool
    {
        return !empty($this->modifiers);
    }

    public function hasModifier(ColumnModifier $modifier): bool
    {
        return \in_array($modifier, $this->modifiers, true);
    }
}
