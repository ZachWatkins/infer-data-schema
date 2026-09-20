<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema;

use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintParserInterface;
use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintColumnInterface;
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
    const HELP = "index.php <path-or-url> [--db=sqlite|mysql|sqlserver] [--cwd=<current-working-directory>] [--dry-run] [--format=sql,blueprint] [--blueprint-model=<name>] [--blueprint-seeders] [--blueprint-view=blade|inertia] [--blueprint-controller-methods=index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy,<custom>] [--blueprint-model-resource=web,api,index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy] [--save] [--help]";

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
                    $this->writeUsage();

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
                    $this->writeUsage();

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

            if (\str_starts_with($argument, '--blueprint-model-resource=')) {
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
                $this->writeUsage();

                return 1;
            }

            $source = $argument;
        }

        if ($source === null || $currentWorkingDirectory === null) {
            $this->writeUsage();

            return 1;
        }

        if ($this->isHttpSource($source)) {
            $this->writeError(
                'HttpParser requires programmatic PSR-18 client injection and is not '
                    . 'supported directly from the CLI in this version.'
            );

            return 1;
        }

        if (!\str_starts_with($source, '/') && !\preg_match('/^[a-zA-Z]:\\\\/', $source)) {
            $source = $currentWorkingDirectory . \DIRECTORY_SEPARATOR . $source;
        }

        $parserClass = $this->resolveParserClass($format, $source);

        if ($parserClass === null) {
            $this->writeUsage();

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
                if (!$save) {
                    if ($blueprintOptions['seeders']) {
                        $blueprintOptions['seeders'] = [$model->name];
                    }
                    $this->writeToStream(
                        $this->stdout,
                        $lexer->toString(
                            new BlueprintConfig(
                                [$model],
                                $blueprintOptions['view'],
                                $blueprintOptions['methods'],
                                $blueprintOptions['resources'],
                                $blueprintOptions['seeders'],
                            )
                        )
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

    private function writeUsage(): void
    {
        $this->writeToStream(
            $this->stderr,
            'Usage: ' . self::HELP . \PHP_EOL
        );
    }

    private function writeSQLColumns(SQLColumnCollectionInterface $columns): void
    {
        foreach ($columns->getColumns() as $column) {
            $this->writeToStream($this->stdout, $this->formatSQLColumn($column) . \PHP_EOL);
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

    private function formatBlueprintColumn(BlueprintColumnInterface $column): string
    {
        $modifiers = \implode(
            ' ',
            \array_map(
                static fn(ColumnModifier $modifier): string => $modifier->value,
                $column->getModifiers(),
            )
        );

        if ($modifiers === '') {
            return \sprintf('%s: %s', strtolower($column->getName()), $column->getType());
        }

        return \sprintf('%s: %s %s', strtolower($column->getName()), $column->getType(), $modifiers);
    }

    private function writeError(string $message): void
    {
        $this->writeToStream($this->stderr, $message . \PHP_EOL);
    }

    /**
     * @param resource $stream
     */
    private function writeToStream($stream, string $message): void
    {
        \fwrite($stream, $message);
    }
}
