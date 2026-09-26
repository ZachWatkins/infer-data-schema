<?php

declare(strict_types=1);

use Tests\Blueprint\Fixtures\Build\TestBlueprintGenerator;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigView;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigResource;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintConfig;

require_once __DIR__ . '/../../../vendor/autoload.php';

$outDir = __DIR__ . DIRECTORY_SEPARATOR . 'blueprint' . DIRECTORY_SEPARATOR;
$existingFiles = glob($outDir . '*.yaml');
foreach ($existingFiles as $file) {
    unlink($file);
}
$blueprintGenerator = new TestBlueprintGenerator();
$blueprintGenerator->generate(__DIR__ . '/../../SQL/fixtures/data/test_mysql.json', $outDir . 'test_mysql_basic.yaml');
$blueprintGenerator->generate(__DIR__ . '/../../SQL/fixtures/data/test_mysql.json', $outDir . 'test_mysql_inertia_basic.yaml', new BlueprintConfig(
    view: BlueprintConfigView::Inertia,
    resources: [BlueprintConfigResource::Web],
    seeders: true
));
$blueprintGenerator->generate(__DIR__ . '/../../SQL/fixtures/data/test_mysql.json', $outDir . 'test_mysql_inertia_view_only.yaml', new BlueprintConfig(
    view: BlueprintConfigView::Inertia,
    resources: [BlueprintConfigResource::Index, BlueprintConfigResource::Show]
));
$blueprintGenerator->generate(__DIR__ . '/../../SQL/fixtures/data/test_mysql.json', $outDir . 'test_mysql_crud_with_custom_methods.yaml', new BlueprintConfig(
    methods: array_merge(BlueprintConfigResource::webMethods(), ['customMethod'])
));
$blueprintGenerator->generate(__DIR__ . '/../../SQL/fixtures/data/test_mysql.json', $outDir . 'test_mysql_api_methods.yaml', new BlueprintConfig(
    methods: BlueprintConfigResource::apiMethods()
));
