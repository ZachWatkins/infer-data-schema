<?php

/**
 * Generate test CSV file.
 */

namespace Tests\Fixtures\Build\File;

use Tests\Fixtures\Build\TestDataGenerator;

class TestCsvFileGenerator
{
    public function generate(string $fileName, int $length = 10): void
    {
        $generator = new TestDataGenerator();
        $data = $generator->generate($length);

        $directory = __DIR__ . '/../data/';
        $filePath = $directory . $fileName;
        $fp = fopen($filePath, 'w');
        if ($fp === false) {
            throw new \RuntimeException("Failed to open file: $filePath");
        }

        if (!empty($data)) {
            fputcsv($fp, array_keys($data[0]));
            foreach ($data as $row) {
                fputcsv($fp, $row);
            }
        }

        fclose($fp);
    }
}
