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
    private const API_RESOURCE_METHODS = ['api.index', 'api.store', 'api.update', 'api.show', 'api.destroy'];

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
            $tree['controllers'][$model->name] = $this->getControllerTree($model, $config);
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
        $template = [
            'resource' => [],
            'index' => [
                'query' => 'all:[plural]',
                'render' => '[singular].index with:[plural]',
            ],
            'create' => [
                'render' => '[singular].create',
            ],
            'store' => [
                'validate' => '[singular]',
                'save' => '[singular]',
                'flash' => '[singular].id',
                'redirect' => '[plural].index',
            ],
            'show' => [
                'render' => '[singular].show with:[singular]',
            ],
            'edit' => [
                'render' => '[singular].edit with:[singular]',
            ],
            'update' => [
                'validate' => '[singular]',
                'update' => '[singular]',
                'flash' => '[singular].id',
                'redirect' => '[plural].index',
            ],
            'destroy' => [
                'delete' => '[singular]',
                'redirect' => '[plural].index',
            ],
            'api.index' => [
                'query' => 'all:[plural]',
                'resource' => 'collection:[plural]',
            ],
            'api.store' => [
                'validate' => '[singular]',
                'save' => '[singular]',
                'resource' => '[singular]',
            ],
            'api.show' => [
                'resource' => '[singular]',
            ],
            'api.update' => [
                'validate' => '[singular]',
                'update' => '[singular]',
                'resource' => '[singular]',
            ],
            'api.destroy' => [
                'delete' => '[singular]',
                'respond' => 204,
            ],
        ];
        if (!empty($config->resources)) {
            if ($config->view === BlueprintConfigView::Inertia) {
                // Inertia views are not currently auto-resolved by the resource shorthand.
                
            } else {
                $template['resource'] = implode(', ', $config->resources);
            }
        } else {
            unset($template['resource']);
        }
        $filtered = array_intersect_key($template, array_flip($config->methods));
        foreach ($config->methods as $method) {
            if (!isset($template[$method])) {
                $filtered[$method] = [
                    '# <action>' => '<parameters>',
                ];
            }
        }
        foreach ($filtered as $method => $actions) {
            foreach ($actions as $action => $parameters) {
                if (is_string($parameters) && str_contains($parameters, '[singular]')) {
                    $filtered[$method][$action] = str_replace('[singular]', $model->tableNameSingular, $parameters);
                }
                if (is_string($parameters) && str_contains($parameters, '[plural]')) {
                    $filtered[$method][$action] = str_replace('[plural]', $model->tableNamePlural, $parameters);
                }
            }
        }
        if ($config->view === BlueprintConfigView::Inertia) {
            foreach ($filtered as $method => $actions) {
                foreach ($actions as $action => $parameters) {
                    if ('render' === $action) {
                        unset($filtered[$method]['render']);
                        $filtered[$method]['inertia'] = $parameters;
                    }
                }
            }
        }
        return $filtered;
    }

    private function getBladeControllerTree(BlueprintModel $model, array $methods): array
    {
        $values = [
            'index' => [
                'query' => 'all',
                'render' => "{$model->tableNamePlural}.index with:{$model->tableNamePlural}",
            ],
            'create' => [
                'render' => "{$model->tableNamePlural}.create with:{$model->tableNameSingular}",
            ],
            'store' => [
                'validate' => implode(', ', $model->columnNames()),
                'save' => "{$model->tableNameSingular}",
                'redirect' => "{$model->tableNamePlural}.index",
            ],
            'show' => [
                'find' => "{$model->tableNameSingular}.id",
                'render' => "{$model->tableNamePlural}.show with:{$model->tableNameSingular}",
            ],
            'edit' => [
                'find' => "{$model->tableNameSingular}.id",
                'render' => "{$model->tableNamePlural}.edit with:{$model->tableNameSingular}",
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
        $selected = array_intersect_key($values, array_flip($methods));
        foreach ($methods as $method) {
            if (!isset($values[$method])) {
                $selected[$method] = [
                    '# <action>' => '<parameters>',
                ];
            }
        }
        return $selected;
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
