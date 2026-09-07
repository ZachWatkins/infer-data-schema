<?php

/**
 * Generate test HTTP file.
 */

namespace Tests\Fixtures\Build\File;

use Tests\Fixtures\Build\TestDataGenerator;

class TestHttpFileGenerator
{
    public function generate(string $fileName, int $length = 10): void
    {
        $generator = new TestDataGenerator();
        $data = $generator->generate($length);

        $directory = __DIR__ . '/../data/';
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        file_put_contents($directory . $fileName, $json);
    }
}
