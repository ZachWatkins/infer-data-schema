<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Interfaces;

/**
 * Represents an ordered collection of inferred SQL columns.
 *
 * @extends \IteratorAggregate<int, SqlColumnInterface>
 */
interface SqlColumnCollectionInterface extends \Countable, \IteratorAggregate
{
    public function add(SqlColumnInterface $column): static;

    public function get(string $name): ?SqlColumnInterface;

    /**
     * @return array<int, SqlColumnInterface>
     */
    public function getColumns(): array;
}
