<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Enums;

/**
 * Controller resource types supported by the Laravel Shift Blueprint YAML file.
 */
enum BlueprintConfigResource: string
{
    case Web = 'web';
    case Api = 'api';
    case Index = 'index';
    case Create = 'create';
    case Store = 'store';
    case Edit = 'edit';
    case Update = 'update';
    case Show = 'show';
    case Destroy = 'destroy';
    case ApiIndex = 'api.index';
    case ApiStore = 'api.store';
    case ApiUpdate = 'api.update';
    case ApiShow = 'api.show';
    case ApiDestroy = 'api.destroy';
}
