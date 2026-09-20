<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Enums;

/**
 * Controller API methods supported by the Laravel Shift Blueprint YAML file.
 */
enum BlueprintConfigApiMethod: string
{
    case ApiIndex = 'api.index';
    case ApiStore = 'api.store';
    case ApiUpdate = 'api.update';
    case ApiShow = 'api.show';
    case ApiDestroy = 'api.destroy';
}
