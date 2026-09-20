<?php

declare(strict_types=1);

use Tests\Blueprint\Fixtures\Build\TestBlueprintGenerator;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigView;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigResource;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintConfig;

require_once __DIR__ . '/../../../vendor/autoload.php';

$blueprintGenerator = new TestBlueprintGenerator();
$blueprintGenerator->generate(__DIR__ . '/../../fixtures/data/test_mysql.json', 'test_mysql_basic.yaml');
$blueprintGenerator->generate(__DIR__ . '/../../fixtures/data/test_mysql.json', 'test_mysql_inertia_basic.yaml', new BlueprintConfig(
    view: BlueprintConfigView::Inertia,
    resources: [BlueprintConfigResource::Web],
    seeders: true
));
$blueprintGenerator->generate(__DIR__ . '/../../fixtures/data/test_mysql.json', 'test_mysql_inertia_view_only.yaml', new BlueprintConfig(
    view: BlueprintConfigView::Inertia,
    resources: [BlueprintConfigResource::Index, BlueprintConfigResource::Show],
    seeders: true
));
