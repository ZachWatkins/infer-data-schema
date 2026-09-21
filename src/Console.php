<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema;

use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintParserInterface;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintModel;
use ZachWatkins\InferDataSchema\Blueprint\Models\BlueprintConfig;
use ZachWatkins\InferDataSchema\Blueprint\Lexers\BlueprintFileLexer;
use ZachWatkins\InferDataSchema\Blueprint\Enums\BlueprintConfigResource;
use ZachWatkins\InferDataSchema\SQL\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\SQL\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\SQL\Interfaces\ParserInterface as SQLParserInterface;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnCollectionInterface;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnInterface;

final class Console
{
    public const HELP = "Infer data schema from various sources into selected formats. By Zach Watkins.
Usage: {filename} [--db=sqlite|mysql|sqlserver] [--cwd=<current-working-directory>] [--dry-run] [--format=sql,blueprint] [--blueprint-model=<name>] [--blueprint-seeders] [--blueprint-view=blade|inertia] [--blueprint-resource=web,api,index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy] [--blueprint-controller-methods=index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy,<custom>] [--save] [--help] <path-or-url>
Options:
  [--db=]                 Database type. Accepts: sqlite, mysql, sqlserver.
                          Default: mysql.
  [--cwd=]                Set the current working directory.
  [--dry-run]             Perform a trial run without making any changes.
  [--format=]             Output format. Accepts: sql, blueprint. Default: sql.
  [--blueprint-model=]    Specify the Blueprint model name.
  [--blueprint-seeders]   Include seeders in Blueprint output.
  [--blueprint-view=]     Set the Blueprint view type. Accepts: blade, inertia.
                          Default: blade.
  [--blueprint-resource=] Define the Blueprint model controller resources.
                          Accepts: web, api, index, create, store, edit, update,
                          show, destroy, api.index, api.store, api.store,
                          api.update, api.show, api.destroy. Default: none.
  [--blueprint-controller-methods=]
                          Specify the Blueprint controller methods.
                          Accepts: index, create, store, edit, update, show,
                          destroy, api.index, api.store, api.store, api.update,
                          api.show, api.destroy, <custom>. Default: none.
  [--save]                Save the output to a file.
  [--help]                Display this help message.
";
    private string $filename = 'index.php';

    /**
     * @var resource
     */
    private $stdout;

    /**
     * @var resource
     */
    private $stderr;

    /**
     * @var array<string, class-string>
     */
    private array $parserClasses;

    /**
     * @param resource|null $stdout
     * @param resource|null $stderr
     * @param array<string, class-string>|null $parserClasses
     */
    public function __construct($stdout = null, $stderr = null, ?array $parserClasses = null)
    {
        $this->stdout = $stdout ?? \STDOUT;
        $this->stderr = $stderr ?? \STDERR;
        $this->parserClasses = $parserClasses ?? [
            'sql' => [
                'csv' => '\ZachWatkins\InferDataSchema\SQL\Parsers\CsvParser',
                'json' => '\ZachWatkins\InferDataSchema\SQL\Parsers\JsonParser',
                'xml' => '\ZachWatkins\InferDataSchema\SQL\Parsers\XmlParser',
                'xlsx' => '\ZachWatkins\InferDataSchema\SQL\Parsers\ExcelParser',
                'xls' => '\ZachWatkins\InferDataSchema\SQL\Parsers\ExcelParser',
                'ods' => '\ZachWatkins\InferDataSchema\SQL\Parsers\ExcelParser',
            ],
            'blueprint' => [
                'csv' => '\ZachWatkins\InferDataSchema\Blueprint\Parsers\CsvParser',
                'json' => '\ZachWatkins\InferDataSchema\Blueprint\Parsers\JsonParser',
                'xml' => '\ZachWatkins\InferDataSchema\Blueprint\Parsers\XmlParser',
                'xlsx' => '\ZachWatkins\InferDataSchema\Blueprint\Parsers\ExcelParser',
                'xls' => '\ZachWatkins\InferDataSchema\Blueprint\Parsers\ExcelParser',
                'ods' => '\ZachWatkins\InferDataSchema\Blueprint\Parsers\ExcelParser',
            ],
        ];

        $runningPhar = \Phar::running(false);
        if ($runningPhar !== '') {
            $this->filename = basename($runningPhar);
        } elseif (isset($_SERVER['argv'][0]) && !empty($_SERVER['argv'][0])) {
            $this->filename = basename($_SERVER['argv'][0]);
        }
    }

    /**
     * @param array<int, string> $argv
     */
    public function run(array $argv): int
    {
        $source = null;
        $databaseType = DatabaseType::SQLite;
        $currentWorkingDirectory = null;
        $dryRun = false;
        $format = 'sql';
        $blueprintOptions = [
            'model' => null,
            'seeders' => false,
            'view' => null,
            'methods' => [],
            'resources' => [],
        ];
        $save = false;

        foreach (\array_slice($argv, 1) as $argument) {
            if (\str_starts_with($argument, '--help')) {
                $this->writeUsage();

                return 0;
            }

            if (\str_starts_with($argument, '--db=')) {
                $requestedDatabaseType = DatabaseType::tryFrom(\strtolower(\substr($argument, 5)));

                if ($requestedDatabaseType === null) {
                    $this->writeUsage('Error: Invalid database type specified: ' . \substr($argument, 5));

                    return 1;
                }

                $databaseType = $requestedDatabaseType;

                continue;
            }

            if (\str_starts_with($argument, '--cwd=')) {
                $currentWorkingDirectory = \substr($argument, 6);
                continue;
            }

            if (\str_starts_with($argument, '--format=')) {
                $requestedFormat = \strtolower(\substr($argument, 9));

                if (!\in_array($requestedFormat, ['sql', 'blueprint'], true)) {
                    $this->writeUsage('Error: Invalid format specified: ' . $requestedFormat);

                    return 1;
                }

                $format = $requestedFormat;

                continue;
            }

            if (\str_starts_with($argument, '--blueprint-model=')) {
                $blueprintOptions['model'] = \substr($argument, 18);
                continue;
            }

            if (\str_starts_with($argument, '--blueprint-seeders')) {
                $blueprintOptions['seeders'] = true;
                continue;
            }

            if (\str_starts_with($argument, '--save')) {
                $save = true;
                continue;
            }

            if (\str_starts_with($argument, '--blueprint-view=')) {
                $blueprintOptions['view'] = \substr($argument, 17);
                continue;
            }

            if (\str_starts_with($argument, '--blueprint-controller-methods=')) {
                $blueprintOptions['methods'] = \array_map('trim', \explode(',', \substr($argument, 25)));
                continue;
            }

            if (\str_starts_with($argument, '--blueprint-resource=')) {
                $resourceType = \substr($argument, 27);
                $split = \array_map('trim', \explode(',', $resourceType));
                foreach ($split as $resource) {
                    $resolved = BlueprintConfigResource::tryFrom($resource);
                    if ($resolved instanceof BlueprintConfigResource) {
                        $blueprintOptions['resources'][] = $resolved;
                    }
                }
                continue;
            }

            if (\str_starts_with($argument, '--dry-run')) {
                $dryRun = true;
                continue;
            }

            if (\str_starts_with($argument, '--') || $source !== null) {
                $this->writeUsage('Error: Unexpected argument: ' . $argument);

                return 1;
            }

            $source = $argument;
        }

        if ($source === null) {
            $this->writeUsage('Error: Source is not specified.');

            return 1;
        }

        if ($this->isHttpSource($source)) {
            $this->writeError(
                'HttpParser requires programmatic PSR-18 client injection and is not supported directly from the CLI in this version.'
            );

            return 1;
        }

        if (!\str_starts_with($source, '/') && !\preg_match('/^[a-zA-Z]:\\\\/', $source)) {
            if (!file_exists($source)) {
                if (is_string($currentWorkingDirectory) && !empty($currentWorkingDirectory)) {
                    $resolved = $currentWorkingDirectory . \DIRECTORY_SEPARATOR . $source;
                    if (file_exists($resolved)) {
                        $source = $resolved;
                    } else {
                        $this->writeError(sprintf('File path \'%s\' could not be found relative to the current working directory at %s. Provide an absolute path or use the --cwd option.', $source, $currentWorkingDirectory));
                        return 1;
                    }
                } else {
                    $this->writeError(sprintf('File path \'%s\' could not be found relative to the current working directory at %s. Provide an absolute path or use the --cwd option.', $source, getcwd()));
                    return 1;
                }
            } elseif (!is_string($currentWorkingDirectory) || empty($currentWorkingDirectory)) {
                $currentWorkingDirectory = \dirname($source);
            }
        } elseif (!file_exists($source)) {
            $this->writeError(sprintf('File path \'%s\' could not be found.', $source));
            return 1;
        } elseif (!is_string($currentWorkingDirectory) || empty($currentWorkingDirectory)) {
            $currentWorkingDirectory = \dirname($source);
        }

        $parserClass = $this->resolveParserClass($format, $source);

        if ($parserClass === null) {
            $this->writeUsage('Error: Unable to resolve parser class for the specified format and source.');

            return 1;
        }

        if (!\class_exists($parserClass)) {
            $this->writeError(\sprintf('Parser %s is not available.', $parserClass));

            return 1;
        }

        if (\is_a($parserClass, SQLParserInterface::class, true)) {
            /** @var SQLParserInterface $parser */
            $parser = new $parserClass();
            $columns = $parser->parse($source, $databaseType->value);

            if (!$dryRun) {
                $this->writeSQLColumns($columns);
            }
        } elseif (\is_a($parserClass, BlueprintParserInterface::class, true)) {
            /** @var BlueprintParserInterface $parser */
            $parser = new $parserClass();
            $columns = $parser->parse($source);
            $model = new BlueprintModel($blueprintOptions['model'] ?? null, $columns);

            if (!$dryRun) {
                $lexer = new BlueprintFileLexer();
                $blueprintContent = $lexer->toString(
                    new BlueprintConfig(
                        models: [$model],
                        resources: $blueprintOptions['resources'],
                        methods: $blueprintOptions['methods'],
                        seeders: $blueprintOptions['seeders'],
                        view: $blueprintOptions['view'],
                    )
                );
                if (!$save) {
                    $this->writeToStream(
                        $this->stdout,
                        $blueprintContent
                    );
                } else {
                    $destinationPath = realpath($currentWorkingDirectory) . DIRECTORY_SEPARATOR . $model->tableNameSingular . '-blueprint.yaml';
                    file_put_contents($destinationPath, $blueprintContent);
                    $this->writeToStream(
                        $this->stdout,
                        sprintf('Blueprint file saved to %s', $destinationPath)
                    );
                }
            }
        } else {
            $this->writeError(\sprintf('Parser %s does not implement %s or %s.', $parserClass, SQLParserInterface::class, BlueprintParserInterface::class));

            return 1;
        }

        return 0;
    }

    private function isHttpSource(string $source): bool
    {
        return \str_starts_with($source, 'http://') || \str_starts_with($source, 'https://');
    }

    private function resolveParserClass(string $format, string $source): ?string
    {
        $extension = \strtolower(\pathinfo($source, \PATHINFO_EXTENSION));

        if ($extension === '') {
            return null;
        }

        return $this->parserClasses[$format][$extension] ?? null;
    }

    private function writeUsage(string $message = ''): void
    {
        $output = 'Usage: ' . str_replace('{filename}', $this->filename, self::HELP) . "\n";
        if ($message) {
            $output = $message .  "\n" . $output;
        }
        $this->writeToStream(
            $this->stderr,
            $output
        );
    }

    private function writeSQLColumns(SQLColumnCollectionInterface $columns): void
    {
        foreach ($columns->getColumns() as $column) {
            $this->writeToStream($this->stdout, $this->formatSQLColumn($column) . "\n");
        }
    }

    private function formatSQLColumn(SQLColumnInterface $column): string
    {
        $modifiers = \implode(
            ' ',
            \array_map(
                static fn(ColumnModifier $modifier): string => $modifier->value,
                $column->getModifiers(),
            )
        );

        if ($modifiers === '') {
            return \sprintf('%s: %s', $column->getName(), $column->getType());
        }

        return \sprintf('%s: %s %s', $column->getName(), $column->getType(), $modifiers);
    }

    private function writeError(string $message): void
    {
        $this->writeToStream($this->stderr, $message . "\n");
    }

    /**
     * @param resource $stream
     */
    private function writeToStream($stream, string $message): void
    {
        \fwrite($stream, $message);
    }
}
