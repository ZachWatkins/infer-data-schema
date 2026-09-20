<?php

/**
 * Generates test fixture schema files using the source data.
 */

namespace Tests\Blueprint\Fixtures\Build;

use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintParserInterface;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintModel;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintConfig;
use ZachWatkins\InferDataSchema\Blueprint\Lexers\BlueprintFileLexer;

class TestBlueprintGenerator
{
    public function generate(string $dataFilePath, string $blueprintFileName, array $config = ['view' => 'blade', 'resources' => ['web'], 'methods' => [], 'seeders' => true]): void
    {
        $parser = $this->resolveParser(basename($dataFilePath));
        $columns = $parser->parse($dataFilePath);
        $model = new BlueprintModel('Data', $columns);
        $config = new BlueprintConfig(
            models: [$model],
            view: $config['view'],
            resources: $config['resources'],
            methods: $config['methods'],
            seeders: $config['seeders']
        );
        $lexer = new BlueprintFileLexer();
        $output = $lexer->toString($config);

        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'blueprint' . DIRECTORY_SEPARATOR . $blueprintFileName, $output);
    }

    private function resolveParser(string $dataFileName): BlueprintParserInterface
    {
        $extension = pathinfo($dataFileName, PATHINFO_EXTENSION);
        if (!$extension) {
            throw new \InvalidArgumentException("Unable to determine the file extension for $dataFileName");
        }
        $className = '\\ZachWatkins\\InferDataSchema\\Blueprint\\Parsers\\' . ucfirst($extension) . 'Parser';
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Parser class $className does not exist for file extension $extension");
        }
        $parser = new $className();
        if (!$parser instanceof BlueprintParserInterface) {
            throw new \InvalidArgumentException("Parser class $className must implement BlueprintParserInterface");
        }
        return $parser;
    }
}
