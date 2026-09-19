<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Models;

use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigView;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintModel;

/**
 * @property array<BlueprintModel> $models
 * @property BlueprintConfigView $view
 * @property array<string> $methods
 * @property array<string> $resources
 * @property bool $seeders
 */
class BlueprintConfig
{
    /** @var array<int, BlueprintModel> */
    public readonly array $models;

    /** @var BlueprintConfigView */
    public readonly BlueprintConfigView $view;

    /** @var array<int, string> */
    public readonly array $methods;

    /** @var array<int, string> */
    public readonly array $resources;

    public function __construct(
        array $models,
        BlueprintConfigView|string $view = BlueprintConfigView::Blade,
        array $methods = [],
        array $resources = [],
        public readonly bool $seeders = false,
    ) {
        $this->models = $this->resolveModels($models);
        $this->view = $this->resolveView($view);
        $this->methods = $this->resolveMethods($methods);
        $this->resources = $this->resolveResources($resources);
    }

    private function resolveModels(array $models): array
    {
        $resolved = [];
        foreach ($models as $model) {
            if ($model instanceof BlueprintModel) {
                $resolved[] = $model;
            } else {
                throw new \RuntimeException(\sprintf(
                    "Model '%s' is not a valid BlueprintModel instance.",
                    \is_object($model) ? \get_class($model) : \gettype($model)
                ));
            }
        }

        return $resolved;
    }

    private function resolveView(BlueprintConfigView|string $view): BlueprintConfigView
    {
        if ($view instanceof BlueprintConfigView) {
            return $view;
        }

        $resolved = BlueprintConfigView::tryFrom($view);
        if ($resolved === null) {
            throw new \RuntimeException(\sprintf(
                "View '%s' is not a valid option. Accepts: %s.",
                $view,
                \implode(', ', \array_column(BlueprintConfigView::cases(), 'value'))
            ));
        }

        return $resolved;
    }

    /**
     * @param array<string> $methods
     * @return array<string>
     */
    private function resolveMethods(array $methods): array
    {
        $resolved = [];
        foreach (array_unique(array_filter($methods)) as $method) {
            if (\is_string($method)) {
                $resolved[] = $method;
            } else {
                throw new \RuntimeException(\sprintf(
                    "Method '%s' (type: '%s') is not a valid option.",
                    \is_object($method) ? \get_class($method) : \gettype($method),
                    \gettype($method)
                ));
            }
        }

        return $resolved;
    }

    /**
     * Resolves an array of resource strings, ensuring each item is a valid string.
     *
     * @param array<string> $resource
     * @return array<string>
     */
    private function resolveResources(array $resource): array
    {
        $resolved = [];
        foreach (array_unique(array_filter($resource)) as $item) {
            if (\is_string($item)) {
                $resolved[] = $item;
            } else {
                throw new \RuntimeException(\sprintf(
                    "Resource '%s' (type: '%s') is not a valid option.",
                    \is_object($item) ? \get_class($item) : \gettype($item),
                    \gettype($item)
                ));
            }
        }

        return $resolved;
    }
}
