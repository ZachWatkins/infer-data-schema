<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\SQL\Models;

use ZachWatkins\InferDataSchema\SQL\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnInterface;

/**
 * An immutable representation of a single inferred SQL column.
 */
final class SQLColumn implements SQLColumnInterface
{
    /**
     * @param  array<int, ColumnModifier>  $modifiers
     */
    public function __construct(
        private readonly string $name,
        private readonly string $type,
        private readonly array $modifiers = [],
    ) {}

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
