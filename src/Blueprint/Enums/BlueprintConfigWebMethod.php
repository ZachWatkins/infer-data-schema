<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Enums;

/**
 * Controller web methods supported by the Laravel Shift Blueprint YAML file.
 */
enum BlueprintConfigWebMethod: string
{
    case Index = 'index';
    case Create = 'create';
    case Store = 'store';
    case Edit = 'edit';
    case Update = 'update';
    case Show = 'show';
    case Destroy = 'destroy';
}
