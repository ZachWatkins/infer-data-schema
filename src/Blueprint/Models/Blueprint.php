<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Models;

/**
 * This class contains the data necessary to represent a Laravel Shift Blueprint model.
 */
class Blueprint
{
    public function __construct(
        public string $modelName = 'Model',
        protected iterable $columns = []
    ) {}
}
