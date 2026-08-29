<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Interfaces;

use ZachWatkins\InferDataSchema\Enums\DatabaseType;

/**
 * Reads a data source and infers its SQL column schema.
 */
interface ParserInterface
{
    /**
     * @param string $source Path or URI to the data source to parse.
     */
    public function parse(
        string $source,
        DatabaseType $databaseType = DatabaseType::Sqlite,
    ): SqlColumnCollectionInterface;
}
