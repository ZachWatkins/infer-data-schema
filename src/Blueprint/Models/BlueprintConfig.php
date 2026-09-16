<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Models;

use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintModel;

/**
 * @property array<BlueprintModel> $models
 * @property string $view
 * @property array<string> $controllers
 * @property array<string> $seeders
 */
class BlueprintConfig
{
    public function __construct(
        public array $models,
        public string $view = 'blade',
        public array $controllers = [],
        public array $seeders = [],
    ) {
        if (!\in_array($view, ['blade', 'inertia'])) {
            throw new \RuntimeException("View '$view' is not a valid option. Accepts: blade, inertia.");
        }
        foreach ($controllers as $controller) {
            if (!\in_array($controller, self::CONTROLLER_OPTIONS)) {
                throw new \RuntimeException("Controller '$controller' is not a valid option. Accepts: " . implode(', ', self::CONTROLLER_OPTIONS));
            }
        }
    }
}
