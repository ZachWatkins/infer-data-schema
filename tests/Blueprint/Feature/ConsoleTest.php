<?php

declare(strict_types=1);

namespace Tests\Blueprint\Features;

use ZachWatkins\InferDataSchema\Console;

$runConsole = static function (array $argv, ?array $parserClasses = null): array {
    $stdout = \fopen('php://temp', 'w+');
    $stderr = \fopen('php://temp', 'w+');

    if ($stdout === false || $stderr === false) {
        throw new \RuntimeException('Unable to create in-memory output streams.');
    }

    $exitCode = (new Console($stdout, $stderr, $parserClasses))->run($argv);

    \rewind($stdout);
    \rewind($stderr);

    $stdoutOutput = (string) \stream_get_contents($stdout);
    $stderrOutput = (string) \stream_get_contents($stderr);

    \fclose($stdout);
    \fclose($stderr);

    return [
        'exitCode' => $exitCode,
        'stdout' => $stdoutOutput,
        'stderr' => $stderrOutput,
    ];
};

afterEach(function () {
    $expectedSavePath = realpath(__DIR__ . str_replace('/', DIRECTORY_SEPARATOR, '/../../fixtures/data/model-blueprint.yaml'));
    if ($expectedSavePath && file_exists($expectedSavePath)) {
        unlink($expectedSavePath);
    }
});

it('prints usage when no source argument is provided', function () use ($runConsole) {
    $result = $runConsole(['infer-data-schema']);

    expect($result['exitCode'])->toBe(1)
        ->and($result['stdout'])->toBe('')
        ->and($result['stderr'])->toContain('[--cwd=<current-working-directory>] [--db=sqlite|mysql|sqlserver] [--format=sql,blueprint] [--blueprint-model=<name>] [--blueprint-view=blade|inertia] [--blueprint-resource=web,api,index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy] [--blueprint-controller-methods=index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy,<custom>] [--blueprint-seeders] [--save] [--dry-run] [--help] <path-or-url>');
});

it('outputs blueprint YAML file contents to the console if --save is not provided', function () use ($runConsole) {
    $dataFixturePath = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, '/../../fixtures/data/test_mysql.csv');
    $blueprintFixturePath = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, '/../fixtures/blueprint/test_mysql_basic.yaml');
    $result = $runConsole(['infer-data-schema', '--format=blueprint', '--blueprint-model=Model', $dataFixturePath]);

    expect($result['exitCode'])->toBe(0)
        ->and($result['stdout'])->toContain(file_get_contents($blueprintFixturePath));
});

it('saves a blueprint YAML file to disk if --save is provided', function () use ($runConsole) {
    $dataFixturePath = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, '/../../fixtures/data/test_mysql.csv');
    $expectedSavePath = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, '/../../fixtures/data/model-blueprint.yaml');
    $blueprintFixturePath = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, '/../fixtures/blueprint/test_mysql_basic.yaml');
    $result = $runConsole(['infer-data-schema', '--format=blueprint', '--blueprint-model=Model', '--save', $dataFixturePath]);
    expect($result['exitCode'])->toBe(0)
        ->and($result['stdout'])->toContain('Blueprint file saved to ' . realpath($expectedSavePath))
        ->and(file_exists(realpath($expectedSavePath)))->toBeTrue()
        ->and(file_get_contents(realpath($expectedSavePath)))->toBe(file_get_contents($blueprintFixturePath));
});
