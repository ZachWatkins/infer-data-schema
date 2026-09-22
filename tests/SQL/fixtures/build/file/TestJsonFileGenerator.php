<?php

/**
 * Generate test JSON file.
 */

namespace Tests\Fixtures\Build\File;

class TestJsonFileGenerator
{
    public function generate(string $fileName, array $data): void
    {
        $directory = __DIR__ . '/../../data/';
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        file_put_contents($directory . $fileName, $json);
    }
}
