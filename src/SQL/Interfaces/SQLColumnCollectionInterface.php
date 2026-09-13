<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\SQL\Interfaces;

/**
 * Represents an ordered collection of inferred SQL columns.
 *
 * @extends \IteratorAggregate<int, SQLColumnInterface>
 */
interface SQLColumnCollectionInterface extends \Countable, \IteratorAggregate
{
    public function add(SQLColumnInterface $column): static;

    public function get(string $name): ?SQLColumnInterface;

    /**
     * @return array<int, SQLColumnInterface>
     */
    public function getColumns(): array;
}
