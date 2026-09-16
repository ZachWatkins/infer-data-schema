<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Lexers;

use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintConfig;

class BlueprintFileLexer
{
    public function toString(BlueprintConfig $config): string
    {
        $tree = [
            'models' => [],
            'controllers' => [],
            'seeders' => [],
        ];
    }
}
