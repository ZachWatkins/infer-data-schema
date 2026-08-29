<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Models;

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;

/**
 * An immutable representation of a single inferred SQL column.
 */
final class SqlColumn implements SqlColumnInterface
{
    /**
     * @param array<int, ColumnModifier> $modifiers
     */
    public function __construct(
        private readonly string $name,
        private readonly string $type,
        private readonly array $modifiers = [],
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<int, ColumnModifier>
     */
    public function getModifiers(): array
    {
        return $this->modifiers;
    }

    public function hasModifier(ColumnModifier $modifier): bool
    {
        return \in_array($modifier, $this->modifiers, true);
    }
}
