<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Enums;

/**
 * Rendering targets supported when generating a Laravel Blueprint YAML file.
 */
enum BlueprintConfigView: string
{
    case Blade = 'blade';
    case Inertia = 'inertia';
}
