<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\SQL\Models;

use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnCollectionInterface;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnInterface;

/**
 * An ordered collection of inferred SQL columns.
 *
 * @implements \IteratorAggregate<int, SQLColumnInterface>
 */
final class SQLColumnCollection implements SQLColumnCollectionInterface
{
    /**
     * @var array<int, SQLColumnInterface>
     */
    private array $columns = [];

    /**
     * @param iterable<SQLColumnInterface> $columns
     */
    public function __construct(iterable $columns = [])
    {
        foreach ($columns as $column) {
            $this->add($column);
        }
    }

    public function add(SQLColumnInterface $column): static
    {
        $this->columns[] = $column;

        return $this;
    }

    public function get(string $name): ?SQLColumnInterface
    {
        foreach ($this->columns as $column) {
            if ($column->getName() === $name) {
                return $column;
            }
        }

        return null;
    }

    /**
     * @return array<int, SQLColumnInterface>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function count(): int
    {
        return \count($this->columns);
    }

    /**
     * @return \ArrayIterator<int, SQLColumnInterface>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->columns);
    }
}
