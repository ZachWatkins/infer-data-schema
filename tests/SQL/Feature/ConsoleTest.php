<?php

declare(strict_types=1);

use ZachWatkins\InferLaravelBlueprint\Console;

$runConsole = static function (array $argv, ?array $parserClasses = null): array {
    $stdout = \fopen('php://temp', 'w+');
    $stderr = \fopen('php://temp', 'w+');

    if ($stdout === false || $stderr === false) {
        throw new RuntimeException('Unable to create in-memory output streams.');
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
    if (file_exists('dataset.csv')) {
        unlink('dataset.csv');
    }
});

it('prints usage when no source argument is provided', function () use ($runConsole) {
    $result = $runConsole(['infer-laravel-blueprint']);

    expect($result['exitCode'])->toBe(1)
        ->and($result['stdout'])->toBe('')
        ->and($result['stderr'])->toContain('Usage: index.php [--cwd=<current-working-directory>] [--db=sqlite|mysql|sqlserver] [--format=sql,blueprint] [--blueprint-model=<name>] [--blueprint-view=blade|inertia] [--blueprint-resource=web,api,index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy] [--blueprint-controller-methods=index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy,<custom>] [--blueprint-seeders] [--http-header=<name>:<value>] [--save] [--dry-run] [--help] <path-or-url>');
})->group('sql', 'console');

it('prints usage for an unsupported source extension', function () use ($runConsole) {
    $result = $runConsole(['infer-laravel-blueprint', 'dataset.sql']);

    expect($result['exitCode'])->toBe(1)
        ->and($result['stdout'])->toBe('')
        ->and($result['stderr'])->toContain('File path \'dataset.sql\' could not be found relative to the current working directory at')
        ->and($result['stderr'])->toContain('. Provide an absolute path or use the --cwd option');
})->group('sql', 'console');

it('rejects http and https sources from the cli', function (string $source) use ($runConsole) {
    $result = $runConsole(['infer-laravel-blueprint', '--format=sql', $source, '--cwd='.getcwd()]);

    expect($result['exitCode'])->toBe(1)
        ->and($result['stdout'])->toBe('')
        ->and($result['stderr'])->toContain(
            'HTTP sources are supported only with --format=blueprint.'
        );
})->with([
    'http source' => 'http://example.com/data.csv',
    'https source' => 'https://example.com/data.csv',
])->group('sql', 'console');

it('fails gracefully when the resolved parser class is unavailable', function () use ($runConsole) {
    file_put_contents('dataset.csv', 'id,name\n1,John Doe');
    $result = $runConsole(
        ['infer-laravel-blueprint', 'dataset.csv', '--format=sql', '--cwd='.getcwd()],
        [
            'sql' => ['csv' => '\Tests\Fixtures\MissingCsvParser'],
        ]
    );

    expect($result['exitCode'])->toBe(1)
        ->and($result['stdout'])->toBe('')
        ->and($result['stderr'])->toContain('Parser \Tests\Fixtures\MissingCsvParser is not available.');
})->group('sql', 'console');
