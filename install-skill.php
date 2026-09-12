<?php

declare(strict_types=1);

// Copy the agent skill and all script files to ~/.copilot/skills/infer-laravel-blueprint in a way that is compatible with Mac, Linux, and Windows.

$isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

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
    copy('index.php', $destination . '/index.php');
    shell_exec(sprintf('cp -r %s %s', 'src/', $destination . '/src/'));
    shell_exec(sprintf('cp -r %s %s', 'vendor/', $destination . '/vendor/'));
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
    copy('index.php', $destination . '/index.php');
    shell_exec(sprintf('xcopy %s %s /S /Y', 'src\\', $destination . '\\src\\'));
    shell_exec(sprintf('xcopy %s %s /S /Y', 'vendor\\', $destination . '\\vendor\\'));
}
