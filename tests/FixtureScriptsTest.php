<?php

describe('fixture build scripts', function () {
    it('can run the SQL and blueprint fixture builders from scripts/', function () {
        $root = dirname(__DIR__);

        foreach (['scripts/build-fixtures.php', 'scripts/build-blueprint-fixtures.php'] as $script) {
            $scriptPath = $root . DIRECTORY_SEPARATOR . $script;
            expect(file_exists($scriptPath))->toBeTrue();

            $command = sprintf('php %s 2>&1', escapeshellarg($scriptPath));
            exec($command, $output, $exitCode);

            expect($exitCode)->toBe(0, implode(PHP_EOL, $output));
        }
    });
});
