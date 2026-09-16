<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Models;

class BlueprintModelController
{
    private const OPTIONS = ['resource', 'resource:api', 'resource:web', 'index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'api.index', 'api.store', 'api.show', 'api.update', 'api.destroy', 'invokable'];

    public readonly array $methods;

    public function __construct(
        protected BlueprintModel $model,
        array $methodsParam,
        protected string $view = 'blade'
    ) {
        $invalidMethods = array_diff($methodsParam, self::OPTIONS);
        if (!empty($invalidMethods)) {
            throw new \RuntimeException(
                "Invalid controller methods: " . implode(', ', $invalidMethods) . ". Accepts: " . implode(', ', self::OPTIONS)
            );
        }

        $this->methods = $this->assembleMethods($methodsParam);
    }

    protected function assembleMethods(array $methodsParam): array
    {
        $tree = [];
        $renderKey = match ($this->view) {
            'blade' => 'render',
            'inertia' => 'inertia',
            default => 'render',
        };
        foreach ($methodsParam as $method) {
            switch ($method) {
                case 'resource':
                    $tree['resource'] = true;
                    break;
                case 'resource:api':
                    $tree['resource'] = 'api';
                    break;
                case 'resource:web':
                    $tree['resource'] = 'web';
                    break;
                case 'index':
                    $tree['index'] = [
                        'query' => 'all',
                        $renderKey => sprintf('%s.index with:%s', $this->model->tableNamePlural, $this->model->tableNamePlural)
                    ];
                    break;
                case 'create':
                    $tree['create'] = [
                        $renderKey => sprintf('%s.create with:%s', $this->model->tableNamePlural, $this->model->tableNameSingular)
                    ];
                    break;
                case 'store':
                    $tree['store'] = [
                        'validate' => implode(', ', $this->model->columnNames()),
                        'save' => $this->model->tableNameSingular,
                        'redirect' => sprintf('%s.index', $this->model->tableNamePlural)
                    ];
                    break;
                case 'show':
                    $tree['show'] = [
                        'find' => sprintf('%s.id', $this->model->tableNameSingular),
                        $renderKey => sprintf('%s.show with:%s', $this->model->tableNamePlural, $this->model->tableNameSingular)
                    ];
                    break;
                case 'edit':
                    $tree['edit'] = [
                        'find' => sprintf('%s.id', $this->model->tableNameSingular),
                        $renderKey => sprintf('%s.edit with:%s', $this->model->tableNamePlural, $this->model->tableNameSingular)
                    ];
                    break;
                case 'update':
                    $tree['update'] = [
                        'validate' => implode(', ', $this->model->columnNames()),
                        'find' => sprintf('%s.id', $this->model->tableNameSingular),
                        'save' => $this->model->tableNameSingular,
                        'redirect' => sprintf('%s.index', $this->model->tableNamePlural)
                    ];
                    break;
                case 'destroy':
                    $tree['destroy'] = [
                        'find' => sprintf('%s.id', $this->model->tableNameSingular),
                        'delete' => $this->model->tableNameSingular,
                    ];
                    break;
                case 'api.index':
                    $tree['api.index'] = true;
                    break;
                case 'api.store':
                    $tree['api.store'] = true;
                    break;
                case 'api.show':
                    $tree['api.show'] = true;
                    break;
                case 'api.update':
                    $tree['api.update'] = true;
                    break;
                case 'api.destroy':
                    $tree['api.destroy'] = true;
                    break;
                case 'invokable':
                    $tree['invokable'] = true;
                    break;
            }
        }
        return $tree;
    }
}
