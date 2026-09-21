<?php

declare(strict_types=1);

// Copy the agent skill and all script files to ~/.copilot/skills/infer-laravel-blueprint in a way that is compatible with Mac, Linux, and Windows.
$isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
$architecture = php_uname('m');
if (!in_array($architecture, ['x86_64', 'arm64', 'AMD64'])) {
    throw new RuntimeException(sprintf('Unsupported architecture: %s', $architecture));
}
$architectureKey = match ($architecture) {
    'x86_64', 'AMD64' => 'x64',
    'arm64' => 'arm',
    default => throw new RuntimeException(sprintf('Unsupported architecture: %s', $architecture)),
};
$phpackerExecutablePaaths = [
    'linux' => [
        'arm' => 'build/linux/linux-arm',
        'x64' => 'build/linux/linux-x64'
    ],
    'mac' => [
        'arm' => 'build/mac/mac-arm',
        'x64' => 'build/mac/mac-x64'
    ],
    'windows' => 'build/windows/windows-x64'
];
$phpackerFilePath = match (true) {
    PHP_OS_FAMILY === 'Darwin' => $phpackerExecutablePaaths['mac'][$architectureKey],
    !$isWindows => $phpackerExecutablePaaths['linux'][$architectureKey],
    $isWindows => $phpackerExecutablePaaths['windows'],
    default => throw new RuntimeException(sprintf('Unsupported platform: %s', PHP_OS_FAMILY)),
};

if (!$isWindows) {
    $destination = getenv('HOME') . '/.copilot/skills/infer-laravel-blueprint';
    if (is_dir($destination)) {
        // Empty the directory before copying new files.
        $files = glob($destination . '/*');
        foreach ($files as $file) {
            if (is_dir($file)) {
                shell_exec(sprintf('rm -rf %s', escapeshellarg($file)));
            } else {
                unlink($file);
            }
        }
    } else {
        mkdir($destination, 0777, true);
    }
    copy('LICENSE', $destination . '/LICENSE');
    copy('SKILL.md', $destination . '/SKILL.md');
    copy($phpackerFilePath, $destination . '/' . 'infer-data-schema');
} else {
    $destination = getenv('USERPROFILE') . '\\.copilot\\skills\\infer-laravel-blueprint';
    if (is_dir($destination)) {
        // Empty the directory before copying new files.
        $files = glob($destination . '\\*');
        foreach ($files as $file) {
            if (is_dir($file)) {
                shell_exec(sprintf('rmdir /S /Q %s', escapeshellarg($file)));
            } else {
                unlink($file);
            }
        }
    } else {
        mkdir($destination, 0777, true);
    }
    copy('LICENSE', $destination . '/LICENSE');
    copy('SKILL.md', $destination . '/SKILL.md');
    copy($phpackerFilePath, $destination . '\\infer-data-schema');
}
