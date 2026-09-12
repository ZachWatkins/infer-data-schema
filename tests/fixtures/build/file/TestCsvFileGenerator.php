<?php

/**
 * Generate test CSV file.
 */

namespace Tests\Fixtures\Build\File;

class TestCsvFileGenerator
{
    public function generate(string $fileName, array $data): void
    {
        $directory = __DIR__ . '/../../data/';
        $filePath = $directory . $fileName;
        $fp = fopen($filePath, 'w');
        if ($fp === false) {
            throw new \RuntimeException("Failed to open file: $filePath");
        }

        if (!empty($data)) {
            fputcsv($fp, array_keys($data[0]), escape: '\\');
            foreach ($data as $row) {
                $formattedRow = array_map(
                    static fn(mixed $val): mixed => is_bool($val) ? ($val ? 'true' : 'false') : $val,
                    $row,
                );
                fputcsv($fp, $formattedRow, escape: '\\');
            }
        }

        fclose($fp);
    }
}
