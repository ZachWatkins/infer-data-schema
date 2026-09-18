<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Models;

use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigMethod;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigResource;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigView;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintModel;

/**
 * @property array<BlueprintModel> $models
 * @property BlueprintConfigView $view
 * @property array<BlueprintConfigMethod> $methods
 * @property BlueprintConfigResource $resource
 * @property bool $seeders
 */
class BlueprintConfig
{
    /** @var array<BlueprintModel> */
    public readonly array $models;

    /** @var BlueprintConfigView */
    public readonly BlueprintConfigView $view;

    /** @var array<BlueprintConfigMethod> */
    public readonly array $methods;

    /** @var BlueprintConfigResource */
    public readonly BlueprintConfigResource $resource;

    public function __construct(
        array $models,
        BlueprintConfigView|string $view = BlueprintConfigView::Blade,
        array $methods = [],
        BlueprintConfigResource|string $resource = BlueprintConfigResource::None,
        public readonly bool $seeders = false,
    ) {
        $this->models = $this->resolveModels($models);
        $this->view = $this->resolveView($view);
        $this->methods = $this->resolveMethods($methods);
        $this->resource = $this->resolveResource($resource);
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
     * @param array<BlueprintConfigMethod|string> $methods
     * @return array<BlueprintConfigMethod>
     */
    private function resolveMethods(array $methods): array
    {
        $resolved = [];
        foreach ($methods as $method) {
            if ($method instanceof BlueprintConfigMethod) {
                $resolved[] = $method;
            } else {
                $value = BlueprintConfigMethod::tryFrom($method);
                if ($value === null) {
                    throw new \RuntimeException(\sprintf(
                        "Method '%s' is not a valid option. Accepts: %s.",
                        $method,
                        \implode(', ', \array_column(BlueprintConfigMethod::cases(), 'value'))
                    ));
                }
                $resolved[] = $value;
            }
        }

        return $resolved;
    }

    private function resolveResource(BlueprintConfigResource|string $resource): BlueprintConfigResource
    {
        if ($resource instanceof BlueprintConfigResource) {
            return $resource;
        }

        $resolved = BlueprintConfigResource::tryFrom($resource);
        if ($resolved === null) {
            throw new \RuntimeException(\sprintf(
                "Resource '%s' is not a valid option. Accepts: %s.",
                $resource,
                \implode(', ', \array_column(BlueprintConfigResource::cases(), 'value'))
            ));
        }

        return $resolved;
    }
}
