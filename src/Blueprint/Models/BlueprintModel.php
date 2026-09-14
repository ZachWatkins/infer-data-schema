<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Models;

class BlueprintModel
{
    public function __construct(
        public string $name,
        protected BlueprintColumnCollection $columns
    ) {}
}
