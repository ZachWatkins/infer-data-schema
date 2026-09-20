<?php

/**
 * Generates test fixture schema files using the source data.
 */

namespace Tests\Fixtures\Build;

use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintParserInterface;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintModel;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintConfig;
use ZachWatkins\InferDataSchema\Blueprint\Lexers\BlueprintFileLexer;

class TestBlueprintGenerator
{
    public function generate(string $dataFileName, string $blueprintFileName, array $config = ['view' => 'blade', 'resources' => ['web'], 'methods' => [], 'seeders' => true]): void
    {
        $parser = $this->resolveParser($dataFileName);
        $directory = __DIR__ . '/../data/';
        $filePath = $directory . $dataFileName;
        $columns = $parser->parse($filePath);
        $model = new BlueprintModel('Data', $columns);
        $config = new BlueprintConfig(
            models: [$model],
            view: $config['view'],
            resources: $config['resources'],
            methods: $config['methods'],
            seeders: $config['seeders']
        );
        // Example output:
        // models:
        //   Data:
        //     id: TinyInt unique unsigned autoIncrement
        //     name: Varchar unique
        //     birthday: Date
        //     created_at: DateTime
        //     accept_terms: Boolean
        //     deleted_at: DateTime nullable
        //
        // controllers:
        //   DataController:
        //     resource: web
        //
        // seeders: Data
        $lexer = new BlueprintFileLexer();
        $output = $lexer->toString($config);

        file_put_contents(__DIR__ . '/../blueprint/' . $blueprintFileName, $output);
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
