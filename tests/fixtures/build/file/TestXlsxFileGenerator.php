<?php
/**
 * Generate test XLSX file.
 */

namespace Tests\Fixtures\Build\File;

use Tests\Fixtures\Build\TestDataGenerator;

class TestXlsxFileGenerator
{
    public function generate(string $fileName, int $length = 10): void
    {
        $generator = new TestDataGenerator();
        $data = $generator->generate($length);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($data)) {
            $sheet->fromArray(array_keys($data[0]), null, 'A1');
            $sheet->fromArray($data, null, 'A2');
        }

        $directory = __DIR__ . '/../data/';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($directory . $fileName);
    }
}
