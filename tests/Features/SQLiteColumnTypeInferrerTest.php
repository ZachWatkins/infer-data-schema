<?php

declare(strict_types=1);

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Enums\SqliteColumnType;

// Assert each SQLite column type can infer data correctly.

it('infers an auto-incrementing, unsigned, unique integer id column', function () {
    $columns = infer([
        ['id' => 1, 'name' => 'Norbert'],
        ['id' => 2, 'name' => 'Tomek'],
        ['id' => 3, 'name' => 'Dawid'],
    ], DatabaseType::Sqlite);

    $id = $columns->get('id');

    expect($id->getType())->toBe(SqliteColumnType::Integer->value);
    expect($id->hasModifier(ColumnModifier::AutoIncrement))->toBeTrue();
    expect($id->hasModifier(ColumnModifier::Unsigned))->toBeTrue();
    expect($id->hasModifier(ColumnModifier::Unique))->toBeTrue();
    expect($id->hasModifier(ColumnModifier::Nullable))->toBeFalse();
});

it('marks a column nullable when any row has a null value', function () {
    $columns = infer([
        ['name' => 'Norbert'],
        ['name' => null],
    ]);

    expect($columns->get('name')->hasModifier(ColumnModifier::Nullable))->toBeTrue();
});

it('marks a column unique only when all non-null values are distinct', function () {
    $columns = infer([
        ['category' => 'a'],
        ['category' => 'a'],
        ['category' => 'b'],
    ]);

    expect($columns->get('category')->hasModifier(ColumnModifier::Unique))->toBeFalse();
});

it('detects unsigned integers without marking negative columns unsigned', function () {
    $columns = infer([
        ['balance' => -5],
        ['balance' => 10],
    ]);

    expect($columns->get('balance')->hasModifier(ColumnModifier::Unsigned))->toBeFalse();
});

it('does not detect auto_increment when the sequence has gaps', function () {
    $columns = infer([
        ['id' => 1],
        ['id' => 3],
        ['id' => 5],
    ]);

    expect($columns->get('id')->hasModifier(ColumnModifier::AutoIncrement))->toBeFalse();
});

it('preserves significant leading zeros as text instead of integers', function () {
    $columns = infer([
        ['zip' => '02134'],
        ['zip' => '90210'],
    ]);

    expect($columns->get('zip')->getType())->toBe(SqliteColumnType::Text->value);
});

it('widens integer columns to the smallest safe SQLite type', function () {
    $columns = infer([
        ['big' => 40000],
        ['big' => 1],
    ], DatabaseType::Sqlite);

    expect($columns->get('big')->getType())->toBe(SqliteColumnType::Integer->value);
});

it('infers boolean columns from native booleans and true/false strings', function () {
    $columns = infer([
        ['active' => true],
        ['active' => 'false'],
    ], DatabaseType::Sqlite);

    expect($columns->get('active')->getType())->toBe(SqliteColumnType::Integer->value);
});

it('infers date, datetime and time columns from ISO-8601 strings', function () {
    $columns = infer([
        ['created_on' => '2024-01-15', 'created_at' => '2024-01-15T10:30:00', 'opens_at' => '09:00:00'],
        ['created_on' => '2024-02-20', 'created_at' => '2024-02-20 11:45:00', 'opens_at' => '17:30:00'],
    ], DatabaseType::Sqlite);

    expect($columns->get('created_on')->getType())->toBe(SqliteColumnType::Text->value);
    expect($columns->get('created_at')->getType())->toBe(SqliteColumnType::Text->value);
    expect($columns->get('opens_at')->getType())->toBe(SqliteColumnType::Text->value);
});

it('falls back to varchar or text based on the longest observed string', function () {
    $columns = infer([
        ['short' => 'hi', 'long' => str_repeat('x', 300)],
    ], DatabaseType::Sqlite);

    expect($columns->get('short')->getType())->toBe(SqliteColumnType::Text->value);
    expect($columns->get('long')->getType())->toBe(SqliteColumnType::Text->value);
});

it('resolves a SQL Server tinyint for small unsigned integers and smallint for signed', function () {
    $columns = infer([
        ['age' => 30],
        ['age' => 45],
    ], DatabaseType::SqlServer);

    $signed = infer([
        ['delta' => -10],
        ['delta' => 20],
    ], DatabaseType::SqlServer);

    expect($columns->get('age')->getType())->toBe(SqlServerColumnType::TinyInt->value);
    expect($signed->get('delta')->getType())->toBe(SqlServerColumnType::SmallInt->value);
});

it('distinguishes fixed-width SQL Server char columns from varchar columns', function () {
    $columns = infer([
        ['code' => 'AB', 'description' => 'short'],
        ['code' => 'CD', 'description' => 'a longer value'],
    ], DatabaseType::SqlServer);

    expect($columns->get('code')->getType())->toBe(SqlServerColumnType::Char->value);
    expect($columns->get('description')->getType())->toBe(SqlServerColumnType::Varchar->value);
});

it('defaults a fully-null column to a nullable text/varchar type', function () {
    $columns = infer([
        ['note' => null],
        ['note' => null],
    ]);

    $note = $columns->get('note');

    expect($note->getType())->toBe(SqliteColumnType::Text->value);
    expect($note->hasModifier(ColumnModifier::Nullable))->toBeTrue();
    expect($note->hasModifier(ColumnModifier::Unique))->toBeFalse();
});

it('treats a column missing entirely from a row the same as an explicit null', function () {
    $columns = infer([
        ['id' => 1, 'name' => 'Norb'],
        ['name' => 'Tomek'],
    ], DatabaseType::Sqlite);

    $id = $columns->get('id');

    expect($id->hasModifier(ColumnModifier::Nullable))->toBeTrue();
    expect($id->hasModifier(ColumnModifier::AutoIncrement))->toBeFalse();
});
