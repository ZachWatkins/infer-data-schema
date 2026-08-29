<?php

declare(strict_types=1);

$projectRoot = \dirname(__DIR__);
$buildDirectory = $projectRoot . \DIRECTORY_SEPARATOR . 'build';
$pharPath = $buildDirectory . \DIRECTORY_SEPARATOR . 'infer-data-schema.phar';

$isPharReadonly = static function (): bool {
    return \filter_var(
        \ini_get('phar.readonly'),
        \FILTER_VALIDATE_BOOL,
        \FILTER_NULL_ON_FAILURE
    ) ?? false;
};

$ensureDirectoryExists = static function (string $directory): bool {
    if (\is_dir($directory)) {
        return true;
    }

    return \mkdir($directory, 0777, true);
};

$buildPharStub = static function (): string {
    return <<<'PHP'
#!/usr/bin/env php
<?php

declare(strict_types=1);

Phar::mapPhar('infer-data-schema.phar');

require 'phar://' . __FILE__ . '/vendor/autoload.php';

exit((new \ZachWatkins\InferDataSchema\Console())->run($argv));

__HALT_COMPILER();
PHP;
};

$addFileToPhar = static function (\Phar $phar, string $absolutePath, string $localPath): void {
    if (!\is_file($absolutePath)) {
        throw new \RuntimeException(
            \sprintf('Required file not found: %s', $absolutePath)
        );
    }

    $phar->addFile($absolutePath, $localPath);
};

$addDirectoryToPhar = static function (\Phar $phar, string $projectRoot, string $relativeDirectory): void {
    $absoluteDirectory = $projectRoot
        . \DIRECTORY_SEPARATOR
        . \str_replace('/', \DIRECTORY_SEPARATOR, $relativeDirectory);

    if (!\is_dir($absoluteDirectory)) {
        throw new \RuntimeException(
            \sprintf('Required directory not found: %s', $absoluteDirectory)
        );
    }

    $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator(
            $absoluteDirectory,
            \FilesystemIterator::SKIP_DOTS
        )
    );

    foreach ($iterator as $fileInfo) {
        if (!$fileInfo->isFile()) {
            continue;
        }

        $absolutePath = $fileInfo->getPathname();
        $localPath = \str_replace(
            \DIRECTORY_SEPARATOR,
            '/',
            \substr($absolutePath, \strlen($projectRoot) + 1)
        );

        $phar->addFile($absolutePath, $localPath);
    }
};

$buildPhar = static function (
    string $projectRoot,
    string $pharPath
) use (
    $addDirectoryToPhar,
    $addFileToPhar,
    $buildPharStub
): void {
    if (\is_file($pharPath) && !\unlink($pharPath)) {
        throw new \RuntimeException(
            \sprintf('Unable to remove existing PHAR at %s', $pharPath)
        );
    }

    $phar = new \Phar($pharPath, 0, 'infer-data-schema.phar');
    $phar->startBuffering();

    $addFileToPhar(
        $phar,
        $projectRoot . \DIRECTORY_SEPARATOR . 'bin' . \DIRECTORY_SEPARATOR . 'infer-data-schema',
        'bin/infer-data-schema'
    );
    $addDirectoryToPhar($phar, $projectRoot, 'src');
    $addDirectoryToPhar($phar, $projectRoot, 'vendor');

    $phar->setStub($buildPharStub());
    $phar->stopBuffering();
};

$runPhpacker = static function (string $projectRoot): ?array {
    $phpacker = $projectRoot
        . \DIRECTORY_SEPARATOR
        . 'vendor'
        . \DIRECTORY_SEPARATOR
        . 'bin'
        . \DIRECTORY_SEPARATOR
        . 'phpacker';

    if (!\is_file($phpacker)) {
        return [
            'success' => false,
            'message' => 'Warning: Native binary packaging was skipped because '
                . 'vendor/bin/phpacker was not found.'
                . \PHP_EOL,
        ];
    }

    if (!\function_exists('proc_open')) {
        return [
            'success' => false,
            'message' => 'Warning: Native binary packaging was skipped because '
                . 'proc_open is unavailable.'
                . \PHP_EOL,
        ];
    }

    $command = \sprintf(
        '%s %s build --config=phpacker.json',
        \escapeshellarg(\PHP_BINARY),
        \escapeshellarg($phpacker)
    );

    $descriptorSpecification = [
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ];

    $process = \proc_open($command, $descriptorSpecification, $pipes, $projectRoot);

    if (!\is_resource($process)) {
        return [
            'success' => false,
            'message' => 'Warning: Native binary packaging was skipped because '
                . 'the PHPacker process could not be started.'
                . \PHP_EOL,
        ];
    }

    $stdout = isset($pipes[1]) ? (string) \stream_get_contents($pipes[1]) : '';
    $stderr = isset($pipes[2]) ? (string) \stream_get_contents($pipes[2]) : '';

    if (isset($pipes[1]) && \is_resource($pipes[1])) {
        \fclose($pipes[1]);
    }

    if (isset($pipes[2]) && \is_resource($pipes[2])) {
        \fclose($pipes[2]);
    }

    $exitCode = \proc_close($process);
    $output = \trim($stdout . \PHP_EOL . $stderr);

    if ($exitCode !== 0) {
        $message = 'Warning: Native binary packaging failed and was skipped.';

        if ($output !== '') {
            $message .= \PHP_EOL . $output;
        }

        return [
            'success' => false,
            'message' => $message . \PHP_EOL,
        ];
    }

    if ($output === '') {
        return null;
    }

    return [
        'success' => true,
        'message' => $output . \PHP_EOL,
    ];
};

if ($isPharReadonly()) {
    \fwrite(
        \STDERR,
        'Error: PHAR creation is disabled. Set phar.readonly=0 in php.ini or '
        . 'run with "-d phar.readonly=0" to build the PHAR.'
        . \PHP_EOL
    );

    exit(1);
}

if (!$ensureDirectoryExists($buildDirectory)) {
    \fwrite(
        \STDERR,
        \sprintf('Error: Unable to create build directory at %s', $buildDirectory) . \PHP_EOL
    );

    exit(1);
}

try {
    $buildPhar($projectRoot, $pharPath);
} catch (\Throwable $throwable) {
    \fwrite(\STDERR, \sprintf('Error: %s', $throwable->getMessage()) . \PHP_EOL);

    exit(1);
}

$phpackerResult = $runPhpacker($projectRoot);

if ($phpackerResult !== null) {
    $outputStream = $phpackerResult['success'] ? \STDOUT : \STDERR;

    \fwrite($outputStream, $phpackerResult['message']);
}

\fwrite(\STDOUT, \sprintf('PHAR built successfully at %s', $pharPath) . \PHP_EOL);

exit(0);
