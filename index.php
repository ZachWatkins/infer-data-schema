<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use ZachWatkins\InferDataSchema\Console;

$console = new Console();
$exitCode = $console->run($argv ?? []);
exit($exitCode);
