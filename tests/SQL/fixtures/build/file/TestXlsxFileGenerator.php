<?php

/**
 * Generate test XLSX file.
 */

namespace Tests\Fixtures\Build\File;

class TestXlsxFileGenerator
{
    public function generate(string $fileName, array $data): void
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('FixedUser')
            ->setLastModifiedBy('FixedUser')
            ->setCreated(strtotime('2026-01-01 00:00:00'))
            ->setModified(strtotime('2026-01-01 00:00:00'));
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($data)) {
            $sheet->fromArray(array_keys($data[0]), null, 'A1');
            $sheet->fromArray($data, null, 'A2', true);
        }

        $directory = __DIR__ . '/../../data/';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($directory . $fileName);
    }
}
