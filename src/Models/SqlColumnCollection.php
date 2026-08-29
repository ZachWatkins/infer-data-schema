<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Models;

use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;

/**
 * An ordered collection of inferred SQL columns.
 *
 * @implements \IteratorAggregate<int, SqlColumnInterface>
 */
final class SqlColumnCollection implements SqlColumnCollectionInterface
{
    /**
     * @var array<int, SqlColumnInterface>
     */
    private array $columns = [];

    /**
     * @param iterable<SqlColumnInterface> $columns
     */
    public function __construct(iterable $columns = [])
    {
        foreach ($columns as $column) {
            $this->add($column);
        }
    }

    public function add(SqlColumnInterface $column): static
    {
        $this->columns[] = $column;

        return $this;
    }

    public function get(string $name): ?SqlColumnInterface
    {
        foreach ($this->columns as $column) {
            if ($column->getName() === $name) {
                return $column;
            }
        }

        return null;
    }

    /**
     * @return array<int, SqlColumnInterface>
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
     * @return \ArrayIterator<int, SqlColumnInterface>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->columns);
    }
}
