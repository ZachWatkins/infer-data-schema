<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Lexers;

use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintConfig;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigMethod;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigView;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigResource;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintModel;

class BlueprintFileLexer
{
    private const WEB_RESOURCE_METHODS = ['index', 'create', 'store', 'edit', 'update', 'show', 'destroy'];
    private const API_RESOURCE_METHODS = ['index', 'store', 'update', 'show', 'destroy'];

    public function toTree(BlueprintConfig $config): array
    {
        $tree = [
            'models' => [],
            'controllers' => [],
            'seeders' => [],
        ];
        foreach ($config->models as $model) {
            $tree['models'][$model->name] = [];
            foreach ($model->columns as $column) {
                $values = [$column->type];
                if ($column->hasAttributes()) {
                    $values[0] .= ':' . implode(',', $column->getAttributes());
                }
                if ($column->hasModifiers()) {
                    foreach ($column->getModifiers() as $modifier) {
                        $values[] = (string) $modifier;
                    }
                }
                $tree['models'][$model->name][$column->name] = implode(' ', $values);
            }
        }
        if ($config->methods) {
            foreach ($config->models as $model) {
                $tree['controllers'][$model->name] = [
                    'resource' => [],
                    'index' => [],
                    'create' => [],
                    'store' => [],
                    'show' => [],
                    'edit' => [],
                    'update' => [],
                    'destroy' => [],
                ];

                // Resolve the resource parameter.
                switch ($config->resource) {
                    case BlueprintConfigResource::Web:
                        if ($config->view === BlueprintConfigView::Blade) {
                            $tree['controllers'][$model->name]['resource'] = $config->resource->value;
                        } else {
                            unset($tree['controllers'][$model->name]['resource']);
                        }
                        break;
                    case BlueprintConfigResource::Api:
                        $tree['controllers'][$model->name]['resource'] = $config->resource->value;
                        break;
                    case BlueprintConfigResource::All:
                        if ($config->view === BlueprintConfigView::Blade) {
                            $tree['controllers'][$model->name]['resource'] = $config->resource->value;
                        } else {
                            $tree['controllers'][$model->name]['resource'] = array_map(fn($method) => 'api.' . $method, $apiResourceMethods);
                        }
                        break;
                    case BlueprintConfigResource::None:
                    default:
                        unset($tree['controllers'][$model->name]['resource']);
                        break;
                }

                if ($config->methods) {
                    if (in_array(BlueprintConfigMethod::Index, $config->methods)) {
                        if ($config->view === BlueprintConfigView::Inertia) {
                        }
                    }
                }

                foreach ($config->methods as $method) {
                    switch ($method) {
                        case BlueprintConfigMethod::Index:
                            if ($config->view === BlueprintConfigView::Inertia) {
                                $tree['controllers'][$model->name][0] = [
                                    'index' => [
                                        'query' => 'all',
                                        'inertia' => "{$model->name}/Index with:{$model->tableNamePlural}",
                                    ],
                                ];
                            } else {
                                $tree['controllers'][$model->name][0] = [
                                    'index' => [
                                        'query' => 'all',
                                        'render' => "{$model->tableNamePlural}.index with:{$model->tableNamePlural}",
                                    ],
                                ];
                            }
                            break;
                    }
                }
            }
        }
        if ($config->seeders) {
            foreach ($config->models as $model) {
                $tree['seeders'][] = $model->name;
            }
        }
        return $tree;
    }

    private function getControllerTree(BlueprintModel $model, BlueprintConfig $config): array
    {
        if ($config->resource === BlueprintConfigResource::None && empty($config->methods)) {
            return [];
        }
        if ($config->view === BlueprintConfigView::Inertia) {
            if (empty($config->methods)) {
                switch ($config->resource) {
                    case BlueprintConfigResource::Web:
                    case BlueprintConfigResource::All:
                        return $this->getInertiaControllerTree($model);
                    case BlueprintConfigResource::Api:
                        return [
                            'resource' => 'api',
                        ];
                    case BlueprintConfigResource::None:
                    default:
                        return [];
                }
            }
            // Must resolve combination of resource and method options.
            $tree = $this->getInertiaControllerTree($model);
            // Resource options add many methods using terse syntax.
            $methods = match ($config->resource) {
                BlueprintConfigResource::Web => self::WEB_RESOURCE_METHODS,
                BlueprintConfigResource::Api => self::API_RESOURCE_METHODS,
                BlueprintConfigResource::All => self::WEB_RESOURCE_METHODS,
                BlueprintConfigResource::None => [],
            };
            // Method options explicitly specify which methods should be included.
            if (!in_array(BlueprintConfigMethod::Index, $config->methods)) {
                $methods = array_diff($methods, ['index']);
            }
            if (!in_array(BlueprintConfigMethod::Create, $config->methods)) {
                $methods = array_diff($methods, ['create', 'store']);
            }
            if (!in_array(BlueprintConfigMethod::Read, $config->methods)) {
                $methods = array_diff($methods, ['index', 'show']);
            }
            if (!in_array(BlueprintConfigMethod::Update, $config->methods)) {
                $methods = array_diff($methods, ['edit', 'update']);
            }
            if (!in_array(BlueprintConfigMethod::Delete, $config->methods)) {
                $methods = array_diff($methods, ['destroy']);
            }
            // For the methods in the methods list, delete those missing from the list from the tree.
            foreach (array_keys($tree) as $key) {
                if (!in_array($key, $methods)) {
                    unset($tree[$key]);
                }
            }
            return $tree;
        }
        $tree = match($config->resource) {
            BlueprintConfigResource::Web => [
                'resource' => 'web',
            ],
            BlueprintConfigResource::Api => [
                'resource' => 'api',
            ],
            BlueprintConfigResource::All => [
                'resource' => 'all',
            ],
            BlueprintConfigResource::None => [],
            default => [],
        };
        if (empty($config->methods)) {
            return $tree;
        }
        return $tree;
    }

    private function getInertiaControllerTree(BlueprintModel $model): array
    {
        return [
            'index' => [
                'query' => 'all',
                'inertia' => "{$model->name}/Index with:{$model->tableNamePlural}",
            ],
            'create' => [
                'inertia' => "{$model->name}/Create with:{$model->tableNameSingular}",
            ],
            'store' => [
                'validate' => implode(', ', $model->columnNames()),
                'save' => "{$model->tableNameSingular}",
                'redirect' => "{$model->tableNamePlural}.index",
            ],
            'show' => [
                'find' => "{$model->tableNameSingular}.id",
                'inertia' => "{$model->name}/Show with:{$model->tableNameSingular}",
            ],
            'edit' => [
                'find' => "{$model->tableNameSingular}.id",
                'inertia' => "{$model->name}/Edit with:{$model->tableNameSingular}",
            ],
            'update' => [
                'validate' => implode(', ', $model->columnNames()),
                'find' => "{$model->tableNameSingular}.id",
                'save' => "{$model->tableNameSingular}",
                'redirect' => "{$model->tableNamePlural}.index",
            ],
            'destroy' => [
                'find' => "{$model->tableNameSingular}.id",
                'delete' => "{$model->tableNameSingular}",
                'redirect' => "{$model->tableNamePlural}.index",
            ],
        ];
    }

    public function toString(BlueprintConfig $config): string
    {
        $tree = $this->toTree($config);
        $output = '';
        if ($tree['models']) {
            $output .= "models:\n";
            foreach ($tree['models'] as $model) {
                $output .= "  {$model->name}:\n";
            }
        }
        if ($tree['seeders']) {
            $output .= "seeders: " . \implode(', ', $tree['seeders']) . "\n";
        }
        return $output;
    }
}
