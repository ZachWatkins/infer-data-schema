<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\SQL\ColumnTypeInferrer;
use ZachWatkins\InferDataSchema\SQL\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnCollectionInterface;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test files is bound to a specific PHPUnit\Framework\TestCase class.
| By default, Pest\TestSuite::getInstance()->testCase is used, but you can bind a different TestCase.
|
*/

// pest()->extend(Tests\TestCase::class)->in('Features');

/*
|--------------------------------------------------------------------------
| Shared Test Helpers
|--------------------------------------------------------------------------
*/

/**
 * @param  array<int, array<string, mixed>>  $rows
 */
function infer(array $rows, DatabaseType $databaseType = DatabaseType::SQLite): SQLColumnCollectionInterface
{
    return (new ColumnTypeInferrer)->infer($rows, $databaseType);
}
