<?php

/**
 * Generates test fixture schema files using the source data.
 */

namespace Tests\Fixtures\Build;

use ZachWatkins\InferDataSchema\Parsers\JsonParser;
use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\MySQLColumnType;
use ZachWatkins\InferDataSchema\Enums\SQLiteColumnType;
use ZachWatkins\InferDataSchema\Enums\SQLServerColumnType;

class TestSchemaGenerator
{
    public function generateMySQL(string $dataFileName, string $schemaFileName): void
    {
        $parser = new JsonParser();
        $directory = __DIR__ . '/../data/';
        $filePath = $directory . $dataFileName;
        $schema = $parser->parse($filePath, 'mysql');
        $columns = $schema->getColumns();

        // Example output:
        // declare(strict_types=1);

        // use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
        // use ZachWatkins\InferDataSchema\Enums\MySQLColumnType;
        // use ZachWatkins\InferDataSchema\Models\SQLColumn;
        // use ZachWatkins\InferDataSchema\Models\SQLColumnCollection;

        // return new SQLColumnCollection([
        //     new SQLColumn('id', MySQLColumnType::TinyInt->value, [
        //         ColumnModifier::Unique,
        //         ColumnModifier::Unsigned,
        //         ColumnModifier::AutoIncrement,
        //     ]),
        //     new SQLColumn('name', MySQLColumnType::Varchar->value, [
        //         ColumnModifier::Unique,
        //     ]),
        //     new SQLColumn('birthday', MySQLColumnType::Date->value, []),
        //     new SQLColumn('created_at', MySQLColumnType::DateTime->value, []),
        //     new SQLColumn('accept_terms', MySQLColumnType::Boolean->value, []),
        //     new SQLColumn('deleted_at', MySQLColumnType::DateTime->value, [
        //         ColumnModifier::Nullable,
        //     ]),
        // ]);

        $output = [
            '<?php',
            '',
            'declare(strict_types=1);',
            '',
            'use ZachWatkins\InferDataSchema\Enums\ColumnModifier;',
            'use ZachWatkins\InferDataSchema\Enums\MySQLColumnType;',
            'use ZachWatkins\InferDataSchema\Models\SQLColumn;',
            'use ZachWatkins\InferDataSchema\Models\SQLColumnCollection;',
            '',
            'return new SQLColumnCollection([',
        ];

        foreach ($columns as $column) {
            $columnType = match ($column->getType()) {
                MySQLColumnType::Bit->value => 'Bit',
                MySQLColumnType::TinyInt->value => 'TinyInt',
                MySQLColumnType::SmallInt->value => 'SmallInt',
                MySQLColumnType::MediumInt->value => 'MediumInt',
                MySQLColumnType::Int->value => 'Int',
                MySQLColumnType::BigInt->value => 'BigInt',
                MySQLColumnType::Decimal->value => 'Decimal',
                MySQLColumnType::Boolean->value => 'Boolean',
                MySQLColumnType::Date->value => 'Date',
                MySQLColumnType::Time->value => 'Time',
                MySQLColumnType::DateTime->value => 'DateTime',
                MySQLColumnType::Char->value => 'Char',
                MySQLColumnType::Varchar->value => 'Varchar',
                MySQLColumnType::Text->value => 'Text',
                MySQLColumnType::Json->value => 'Json',
                default => throw new \InvalidArgumentException('Unknown column type: ' . $column->getType()),
            };
            $output[] = '    new SQLColumn(\'' . $column->getName() . '\', MySQLColumnType::' . $columnType . '->value';
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

    public function generateSQLite(string $dataFileName, string $schemaFileName): void
    {
        $parser = new JsonParser();
        $directory = __DIR__ . '/../data/';
        $filePath = $directory . $dataFileName;
        $schema = $parser->parse($filePath, 'sqlite');
        $columns = $schema->getColumns();

        // Example output:
        // declare(strict_types=1);

        // use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
        // use ZachWatkins\InferDataSchema\Enums\MySQLColumnType;
        // use ZachWatkins\InferDataSchema\Models\SQLColumn;
        // use ZachWatkins\InferDataSchema\Models\SQLColumnCollection;

        // return new SQLColumnCollection([
        //     new SQLColumn('id', SQLiteColumnType::TinyInt->value, [
        //         ColumnModifier::Unique,
        //         ColumnModifier::Unsigned,
        //         ColumnModifier::AutoIncrement,
        //     ]),
        //     new SQLColumn('name', SQLiteColumnType::Varchar->value, [
        //         ColumnModifier::Unique,
        //     ]),
        //     new SQLColumn('birthday', SQLiteColumnType::Date->value, []),
        //     new SQLColumn('created_at', SQLiteColumnType::DateTime->value, []),
        //     new SQLColumn('accept_terms', SQLiteColumnType::Boolean->value, []),
        //     new SQLColumn('deleted_at', SQLiteColumnType::DateTime->value, [
        //         ColumnModifier::Nullable,
        //     ]),
        // ]);

        $output = [
            '<?php',
            '',
            'declare(strict_types=1);',
            '',
            'use ZachWatkins\InferDataSchema\Enums\ColumnModifier;',
            'use ZachWatkins\InferDataSchema\Enums\SQLiteColumnType;',
            'use ZachWatkins\InferDataSchema\Models\SQLColumn;',
            'use ZachWatkins\InferDataSchema\Models\SQLColumnCollection;',
            '',
            'return new SQLColumnCollection([',
        ];

        foreach ($columns as $column) {
            $columnType = match ($column->getType()) {
                SQLiteColumnType::Integer->value => 'Integer',
                SQLiteColumnType::Numeric->value => 'Numeric',
                SQLiteColumnType::Real->value => 'Real',
                SQLiteColumnType::Text->value => 'Text',
                default => throw new \InvalidArgumentException('Unknown column type: ' . $column->getType()),
            };
            $output[] = '    new SQLColumn(\'' . $column->getName() . '\', SQLiteColumnType::' . $columnType . '->value';
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

    public function generateSQLServer(string $dataFileName, string $schemaFileName): void
    {
        $parser = new JsonParser();
        $directory = __DIR__ . '/../data/';
        $filePath = $directory . $dataFileName;
        $schema = $parser->parse($filePath, 'sqlserver');
        $columns = $schema->getColumns();

        // Example output:
        // declare(strict_types=1);

        // use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
        // use ZachWatkins\InferDataSchema\Enums\MySQLColumnType;
        // use ZachWatkins\InferDataSchema\Models\SQLColumn;
        // use ZachWatkins\InferDataSchema\Models\SQLColumnCollection;

        // return new SQLColumnCollection([
        //     new SQLColumn('id', SQLServerColumnType::TinyInt->value, [
        //         ColumnModifier::Unique,
        //         ColumnModifier::Unsigned,
        //         ColumnModifier::AutoIncrement,
        //     ]),
        //     new SQLColumn('name', SQLServerColumnType::Varchar->value, [
        //         ColumnModifier::Unique,
        //     ]),
        //     new SQLColumn('birthday', SQLServerColumnType::Date->value, []),
        //     new SQLColumn('created_at', SQLServerColumnType::DateTime->value, []),
        //     new SQLColumn('accept_terms', SQLServerColumnType::Boolean->value, []),
        //     new SQLColumn('deleted_at', SQLServerColumnType::DateTime->value, [
        //         ColumnModifier::Nullable,
        //     ]),
        // ]);

        $output = [
            '<?php',
            '',
            'declare(strict_types=1);',
            '',
            'use ZachWatkins\InferDataSchema\Enums\ColumnModifier;',
            'use ZachWatkins\InferDataSchema\Enums\SQLServerColumnType;',
            'use ZachWatkins\InferDataSchema\Models\SQLColumn;',
            'use ZachWatkins\InferDataSchema\Models\SQLColumnCollection;',
            '',
            'return new SQLColumnCollection([',
        ];

        foreach ($columns as $column) {
            $columnType = match ($column->getType()) {
                SQLServerColumnType::Bit->value => 'Bit',
                SQLServerColumnType::TinyInt->value => 'TinyInt',
                SQLServerColumnType::SmallInt->value => 'SmallInt',
                SQLServerColumnType::Int->value => 'Int',
                SQLServerColumnType::BigInt->value => 'BigInt',
                SQLServerColumnType::Decimal->value => 'Decimal',
                SQLServerColumnType::Date->value => 'Date',
                SQLServerColumnType::Time->value => 'Time',
                SQLServerColumnType::DateTime->value => 'DateTime',
                SQLServerColumnType::Char->value => 'Char',
                SQLServerColumnType::Varchar->value => 'Varchar',
                SQLServerColumnType::NChar->value => 'NChar',
                SQLServerColumnType::NVarchar->value => 'NVarchar',
                SQLServerColumnType::Json->value => 'Json',
                SQLServerColumnType::XML->value => 'XML',
                default => throw new \InvalidArgumentException('Unknown column type: ' . $column->getType()),
            };
            $output[] = '    new SQLColumn(\'' . $column->getName() . '\', SQLServerColumnType::' . $columnType . '->value';
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
