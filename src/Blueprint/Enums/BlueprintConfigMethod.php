<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Enums;

/**
 * Controller methods that can be requested for a generated Blueprint controller.
 */
enum BlueprintConfigMethod: string
{
    case Index = 'index';
    case Create = 'create';
    case Read = 'read';
    case Update = 'update';
    case Delete = 'delete';
}
