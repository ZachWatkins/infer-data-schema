<?php
/**
 * Generate test XML file.
 */

namespace Tests\Fixtures\Build\File;

class TestXmlFileGenerator
{
    public function generate(string $fileName, array $data): void
    {
        $xml = new \SimpleXMLElement('<root/>');
        foreach ($data as $row) {
            $item = $xml->addChild('item');
            foreach ($row as $key => $value) {
                $formattedValue = is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;
                $item->addChild($key, $formattedValue);
            }
        }

        $directory = __DIR__ . '/../../data/';
        $xml->asXML($directory . $fileName);
    }
}
