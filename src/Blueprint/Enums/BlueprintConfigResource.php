<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Enums;

/**
 * Resource types that can be requested for a generated Blueprint model.
 */
enum BlueprintConfigResource: string
{
    case Web = 'web';
    case Api = 'api';
    case All = 'all';
    case None = 'none';
}
