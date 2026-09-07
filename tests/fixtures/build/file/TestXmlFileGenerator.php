<?php
/**
 * Generate test XML file.
 */

namespace Tests\Fixtures\Build\File;

use Tests\Fixtures\Build\TestDataGenerator;

class TestXmlFileGenerator
{
    public function generate(string $fileName, int $length = 10): void
    {
        $generator = new TestDataGenerator();
        $data = $generator->generate($length);

        $xml = new \SimpleXMLElement('<root/>');
        foreach ($data as $row) {
            $item = $xml->addChild('item');
            foreach ($row as $key => $value) {
                $item->addChild($key, (string)$value);
            }
        }

        $directory = __DIR__ . '/../data/';
        $xml->asXML($directory . $fileName);
    }
}
