<?php

/**
 * Generates test fixture schema files using the source data.
 */

namespace Tests\Fixtures\Build;

use ZachWatkins\InferDataSchema\Parsers\JsonParser;
use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\MySqlColumnType;
use ZachWatkins\InferDataSchema\Enums\SqliteColumnType;

class TestSchemaGenerator
{
    public function generateMySql(string $dataFileName, string $schemaFileName): void
    {
        $parser = new JsonParser();
        $directory = __DIR__ . '/../data/';
        $filePath = $directory . $dataFileName;
        $schema = $parser->parse($filePath, 'mysql');
        $columns = $schema->getColumns();

        // Example output:
        // declare(strict_types=1);

        // use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
        // use ZachWatkins\InferDataSchema\Enums\MySqlColumnType;
        // use ZachWatkins\InferDataSchema\Models\SqlColumn;
        // use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

        // return new SqlColumnCollection([
        //     new SqlColumn('id', MySqlColumnType::TinyInt->value, [
        //         ColumnModifier::Unique,
        //         ColumnModifier::Unsigned,
        //         ColumnModifier::AutoIncrement,
        //     ]),
        //     new SqlColumn('name', MySqlColumnType::Varchar->value, [
        //         ColumnModifier::Unique,
        //     ]),
        //     new SqlColumn('birthday', MySqlColumnType::Date->value, []),
        //     new SqlColumn('created_at', MySqlColumnType::DateTime->value, []),
        //     new SqlColumn('accept_terms', MySqlColumnType::Boolean->value, []),
        //     new SqlColumn('deleted_at', MySqlColumnType::DateTime->value, [
        //         ColumnModifier::Nullable,
        //     ]),
        // ]);

        $output = [
            '<?php',
            '',
            'declare(strict_types=1);',
            '',
            'use ZachWatkins\InferDataSchema\Enums\ColumnModifier;',
            'use ZachWatkins\InferDataSchema\Enums\MySqlColumnType;',
            'use ZachWatkins\InferDataSchema\Models\SqlColumn;',
            'use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;',
            '',
            'return new SqlColumnCollection([',
        ];

        foreach ($columns as $column) {
            $columnType = match ($column->getType()) {
                MySqlColumnType::Bit->value => 'Bit',
                MySqlColumnType::TinyInt->value => 'TinyInt',
                MySqlColumnType::SmallInt->value => 'SmallInt',
                MySqlColumnType::MediumInt->value => 'MediumInt',
                MySqlColumnType::Int->value => 'Int',
                MySqlColumnType::BigInt->value => 'BigInt',
                MySqlColumnType::Decimal->value => 'Decimal',
                MySqlColumnType::Boolean->value => 'Boolean',
                MySqlColumnType::Date->value => 'Date',
                MySqlColumnType::Time->value => 'Time',
                MySqlColumnType::DateTime->value => 'DateTime',
                MySqlColumnType::Char->value => 'Char',
                MySqlColumnType::Varchar->value => 'Varchar',
                MySqlColumnType::Text->value => 'Text',
                MySqlColumnType::Json->value => 'Json',
                default => throw new \InvalidArgumentException('Unknown column type: ' . $column->getType()),
            };
            $output[] = '    new SqlColumn(\'' . $column->getName() . '\', MySqlColumnType::' . $columnType . '->value';
            $modifiers = $column->getModifiers();
            if (!empty($modifiers)) {
                $output[array_key_last($output)] .= ', [';
                foreach ($column->getModifiers() as $modifier) {
                    $mod = match ($modifier) {
                        ColumnModifier::Unique => 'Unique',
                        ColumnModifier::Unsigned => 'Unsigned',
                        ColumnModifier::AutoIncrement => 'AutoIncrement',
                        ColumnModifier::Nullable => 'Nullable',
                        default => throw new \InvalidArgumentException('Unknown modifier: ' . $modifier->value),
                    };
                    $output[] = '        ColumnModifier::' . $mod . ',';
                }
                $output[array_key_last($output)] .= "\n    ]";
            }
            $output[array_key_last($output)] .= '),';
        }
        $output[] = ']);';
        $output[] = '';

        file_put_contents(__DIR__ . '/../schema/' . $schemaFileName, implode("\n", $output));
    }

    public function generateSqlite(string $dataFileName, string $schemaFileName): void
    {
        $parser = new JsonParser();
        $directory = __DIR__ . '/../data/';
        $filePath = $directory . $dataFileName;
        $schema = $parser->parse($filePath, 'sqlite');
        $columns = $schema->getColumns();

        // Example output:
        // declare(strict_types=1);

        // use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
        // use ZachWatkins\InferDataSchema\Enums\MySqlColumnType;
        // use ZachWatkins\InferDataSchema\Models\SqlColumn;
        // use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;

        // return new SqlColumnCollection([
        //     new SqlColumn('id', SqliteColumnType::TinyInt->value, [
        //         ColumnModifier::Unique,
        //         ColumnModifier::Unsigned,
        //         ColumnModifier::AutoIncrement,
        //     ]),
        //     new SqlColumn('name', SqliteColumnType::Varchar->value, [
        //         ColumnModifier::Unique,
        //     ]),
        //     new SqlColumn('birthday', SqliteColumnType::Date->value, []),
        //     new SqlColumn('created_at', SqliteColumnType::DateTime->value, []),
        //     new SqlColumn('accept_terms', SqliteColumnType::Boolean->value, []),
        //     new SqlColumn('deleted_at', SqliteColumnType::DateTime->value, [
        //         ColumnModifier::Nullable,
        //     ]),
        // ]);

        $output = [
            '<?php',
            '',
            'declare(strict_types=1);',
            '',
            'use ZachWatkins\InferDataSchema\Enums\ColumnModifier;',
            'use ZachWatkins\InferDataSchema\Enums\SqliteColumnType;',
            'use ZachWatkins\InferDataSchema\Models\SqlColumn;',
            'use ZachWatkins\InferDataSchema\Models\SqlColumnCollection;',
            '',
            'return new SqlColumnCollection([',
        ];

        foreach ($columns as $column) {
            $columnType = match ($column->getType()) {
                SqliteColumnType::Integer->value => 'Integer',
                SqliteColumnType::Numeric->value => 'Numeric',
                SqliteColumnType::Real->value => 'Real',
                SqliteColumnType::Text->value => 'Text',
                default => throw new \InvalidArgumentException('Unknown column type: ' . $column->getType()),
            };
            $output[] = '    new SqlColumn(\'' . $column->getName() . '\', SqliteColumnType::' . $columnType . '->value';
            $modifiers = $column->getModifiers();
            if (!empty($modifiers)) {
                $output[array_key_last($output)] .= ', [';
                foreach ($column->getModifiers() as $modifier) {
                    $mod = match ($modifier) {
                        ColumnModifier::Unique => 'Unique',
                        ColumnModifier::Unsigned => 'Unsigned',
                        ColumnModifier::AutoIncrement => 'AutoIncrement',
                        ColumnModifier::Nullable => 'Nullable',
                        default => throw new \InvalidArgumentException('Unknown modifier: ' . $modifier->value),
                    };
                    $output[] = '        ColumnModifier::' . $mod . ',';
                }
                $output[array_key_last($output)] .= "\n    ]";
            }
            $output[array_key_last($output)] .= '),';
        }
        $output[] = ']);';
        $output[] = '';

        file_put_contents(__DIR__ . '/../schema/' . $schemaFileName, implode("\n", $output));
    }
}
