<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Lexers;

use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintConfig;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigView;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigWebMethod;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigApiMethod;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintModel;

class BlueprintFileLexer
{
    private const API_RESOURCE_METHODS = ['api.index', 'api.store', 'api.update', 'api.show', 'api.destroy'];

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
        if ($tree['controllers']) {
            $output .= "controllers:\n";
            foreach ($tree['controllers'] as $controller => $methods) {
                $output .= "  {$controller}:\n";
                foreach ($methods as $method => $actions) {
                    $output .= "    {$method}:\n";
                    foreach ($actions as $action => $value) {
                        $output .= "      {$action}: {$value}\n";
                    }
                }
            }
        }
        if ($tree['seeders']) {
            $output .= "seeders: " . \implode(', ', $tree['seeders']) . "\n";
        }
        return $output;
    }

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
            $controller = $this->getControllerTree($model, $config);
            if (!empty($controller)) {
                $tree['controllers'][$model->name] = $controller;
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
        if ($config->view === BlueprintConfigView::Inertia) {
            return $this->getInertiaControllerTree($model, $config);
        }
        $template = [
            'index' => [
                'query' => 'all:[plural]',
                'render' => '[singular].index with:[plural]',
            ],
            'create' => [
                'render' => '[singular].create',
            ],
            'store' => [
                'validate' => '[columns]',
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
                'validate' => '[columns]',
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
                'validate' => '[columns]',
                'save' => '[singular]',
                'resource' => '[singular]',
            ],
            'api.show' => [
                'resource' => '[singular]',
            ],
            'api.update' => [
                'validate' => '[columns]',
                'update' => '[singular]',
                'resource' => '[singular]',
            ],
            'api.destroy' => [
                'delete' => '[singular]',
                'respond' => 204,
            ],
        ];
        $result = [];
        if ($config->resources) {
            $result['resources'] = $config->resources;
        }
        foreach (\array_keys($template) as $templateMethod) {
            if (\in_array($templateMethod, $config->methods)) {
                $result[$templateMethod] = $template[$templateMethod];
            }
        }
        $result = $this->resolveConflictingControllerMethods($result);
        $result = $this->resolveModelControllerPlaceholders($result, $model);
        foreach ($config->methods as $method) {
            if (!isset($result[$method])) {
                $result[$method] = [
                    '# <action>' => '<parameters>'
                ];
            }
        }
        return $result;
    }

    private function getInertiaControllerTree(BlueprintModel $model, BlueprintConfig $config): array
    {
        $template = [
            'resource' => [],
            'index' => [
                'query' => 'all:[plural]',
                'inertia' => '[model]/Index with:[plural]',
            ],
            'create' => [
                'inertia' => '[model]/Create',
            ],
            'store' => [
                'validate' => '[columns]',
                'save' => '[singular]',
                'flash' => '[singular].id',
                'redirect' => '[plural].index',
            ],
            'show' => [
                'inertia' => '[model]/Show with:[singular]',
            ],
            'edit' => [
                'inertia' => '[model]/Edit with:[singular]',
            ],
            'update' => [
                'validate' => '[columns]',
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
                'validate' => '[columns]',
                'save' => '[singular]',
                'resource' => '[singular]',
            ],
            'api.show' => [
                'resource' => '[singular]',
            ],
            'api.update' => [
                'validate' => '[columns]',
                'update' => '[singular]',
                'resource' => '[singular]',
            ],
            'api.destroy' => [
                'delete' => '[singular]',
                'respond' => 204,
            ],
        ];
        $result = [];
        if ($config->resources) {
            // Extract web-related resource declarations and move them to the controllers, since Laravel Shift Blueprint does not resolve these shorthands for Inertia views at this time.
            $filteredResources = array_flip($config->resources);
            $webResourceMethods = [];
            if (isset($filteredResources['web'])) {
                $webResourceMethods = array_flip(array_column(BlueprintConfigWebMethod::cases(), 'value'));
                unset($filteredResources['web']);
            }
            // Look at each resource declaration and move web methods to extractedResourceMethods.
            foreach (BlueprintConfigWebMethod::cases() as $case) {
                $method = $case->value;
                if (isset($filteredResources[$method])) {
                    if (!isset($webResourceMethods[$method])) {
                        $webResourceMethods[$method] = true;
                    }
                    unset($filteredResources[$method]);
                }
            }
            if (!empty($filteredResources)) {
                $result['resource'] = implode(', ', array_keys($filteredResources));
            }
            if (!empty($webResourceMethods)) {
                foreach (\array_keys($template) as $method) {
                    if (isset($webResourceMethods[$method])) {
                        $result[$method] = $template[$method];
                    } else {
                        // To preserve the declared order of methods for future assignment, set a null value and remove it later.
                        $result[$method] = null;
                    }
                }
            }
        }
        foreach ($config->methods as $method) {
            // Apply web resource methods declared in $config->methods.
            $attempt = BlueprintConfigWebMethod::tryFrom($method);
            if ($attempt !== null && isset($result[$method]) && $result[$method] === null) {
                $result[$method] = $template[$method];
            }
            // Apply API resource methods declared in $config->methods.
            $attempt = BlueprintConfigApiMethod::tryFrom($method);
            if ($attempt !== null && isset($result[$method]) && $result[$method] === null) {
                $result[$method] = $template[$method];
            }
        }
        foreach ($result as $method => $actions) {
            if ($actions === null) {
                unset($result[$method]);
            }
        }
        $result = $this->resolveConflictingControllerMethods($result);
        $result = $this->resolveModelControllerPlaceholders($result, $model);
        foreach ($config->methods as $method) {
            if (!isset($result[$method])) {
                $result[$method] = [
                    '# <action>' => '<parameters>'
                ];
            }
        }
        return $result;
    }

    private function resolveModelControllerPlaceholders(array $tree, BlueprintModel $model): array
    {
        foreach (array_keys($tree) as $method) {
            $actions = $tree[$method];
            foreach ($actions as $action => $parameters) {
                if (is_string($parameters)) {
                    if (str_contains($parameters, '[singular]')) {
                        $actions[$action] = str_replace('[singular]', $model->tableNameSingular, $parameters);
                    }
                    if (str_contains($parameters, '[plural]')) {
                        $actions[$action] = str_replace('[plural]', $model->tableNamePlural, $parameters);
                    }
                    if (str_contains($parameters, '[model]')) {
                        $actions[$action] = str_replace('[model]', $model->name, $parameters);
                    }
                    if (str_contains($parameters, '[columns]')) {
                        $actions[$action] = str_replace('[columns]', implode(', ', $model->columnNames()), $parameters);
                    }
                }
            }
            $tree[$method] = $actions;
        }
        return $tree;
    }

    private function resolveConflictingControllerMethods(array $tree): array
    {
        foreach ($tree as $method => $actions) {
            if (\str_starts_with($method, 'api.')) {
                $baseMethod = substr($method, 4);
                if (isset($tree[$baseMethod])) {
                    unset($tree[$method]);
                } else {
                    $tree[$baseMethod] = $actions;
                    unset($tree[$method]);
                }
            }
        }
        return $tree;
    }
}
