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
    /**
     * Generates a test blueprint file from the given data file and configuration.
     * @param string $dataFilePath The path to the source data file.
     * @param string $blueprintFilePath The path to the output blueprint file.
     * @param BlueprintConfig $config The configuration options for generating the blueprint file.
     * @return void
     */
    public function generate(string $dataFilePath, string $blueprintFilePath, BlueprintConfig $config = new BlueprintConfig()): void
    {
        $parser = $this->resolveParser(basename($dataFilePath));
        $columns = $parser->parse($dataFilePath);
        $model = new BlueprintModel('Model', $columns);
        $config->addModel($model);
        $lexer = new BlueprintFileLexer();
        $output = $lexer->toString($config);

        file_put_contents($blueprintFilePath, $output);
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
