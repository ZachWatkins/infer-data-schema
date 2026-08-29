<?php

declare(strict_types=1);

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

it('prints usage when no source argument is provided', function () use ($runConsole) {
    $result = $runConsole(['infer-data-schema']);

    expect($result['exitCode'])->toBe(1)
        ->and($result['stdout'])->toBe('')
        ->and($result['stderr'])->toContain('Usage: infer-data-schema <path-or-url> [--db=sqlite|mysql|sqlserver]');
});

it('prints usage for an unsupported source extension', function () use ($runConsole) {
    $result = $runConsole(['infer-data-schema', 'dataset.txt']);

    expect($result['exitCode'])->toBe(1)
        ->and($result['stdout'])->toBe('')
        ->and($result['stderr'])->toContain('Usage: infer-data-schema <path-or-url> [--db=sqlite|mysql|sqlserver]');
});

it('rejects http and https sources from the cli', function (string $source) use ($runConsole) {
    $result = $runConsole(['infer-data-schema', $source]);

    expect($result['exitCode'])->toBe(1)
        ->and($result['stdout'])->toBe('')
        ->and($result['stderr'])->toContain(
            'HttpParser requires programmatic PSR-18 client injection and is not '
            . 'supported directly from the CLI in this version.'
        );
})->with([
    'http source' => 'http://example.com/data.csv',
    'https source' => 'https://example.com/data.csv',
]);

it('fails gracefully when the resolved parser class is unavailable', function () use ($runConsole) {
    $result = $runConsole(
        ['infer-data-schema', 'dataset.csv'],
        [
            'csv' => '\Tests\Fixtures\MissingCsvParser',
        ]
    );

    expect($result['exitCode'])->toBe(1)
        ->and($result['stdout'])->toBe('')
        ->and($result['stderr'])->toContain('Parser \Tests\Fixtures\MissingCsvParser is not available.');
});
