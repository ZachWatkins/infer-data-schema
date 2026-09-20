<?php

declare(strict_types=1);

use Tests\Blueprint\Fixtures\Build\TestBlueprintGenerator;

require_once __DIR__ . '/../../../vendor/autoload.php';

$blueprintGenerator = new TestBlueprintGenerator();
$blueprintGenerator->generate(__DIR__ . '/../../fixtures/data/test_mysql.json', 'test_mysql_basic.yaml');
$blueprintGenerator->generate(__DIR__ . '/../../fixtures/data/test_mysql.json', 'test_mysql_basic_inertia.yaml', [
    'view' => 'inertia',
    'resources' => ['web'],
    'methods' => [],
    'seeders' => true
]);
