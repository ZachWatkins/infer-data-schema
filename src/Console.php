<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema;

use ZachWatkins\InferDataSchema\Enums\ColumnModifier;
use ZachWatkins\InferDataSchema\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Interfaces\ParserInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnInterface;

final class Console
{
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
            'csv' => '\ZachWatkins\InferDataSchema\Parsers\CsvParser',
            'json' => '\ZachWatkins\InferDataSchema\Parsers\JsonParser',
            'xml' => '\ZachWatkins\InferDataSchema\Parsers\XmlParser',
            'xlsx' => '\ZachWatkins\InferDataSchema\Parsers\ExcelParser',
            'xls' => '\ZachWatkins\InferDataSchema\Parsers\ExcelParser',
            'ods' => '\ZachWatkins\InferDataSchema\Parsers\ExcelParser',
        ];
    }

    /**
     * @param array<int, string> $argv
     */
    public function run(array $argv): int
    {
        $source = null;
        $databaseType = DatabaseType::Sqlite;

        foreach (\array_slice($argv, 1) as $argument) {
            if (\str_starts_with($argument, '--db=')) {
                $requestedDatabaseType = DatabaseType::tryFrom(\strtolower(\substr($argument, 5)));

                if ($requestedDatabaseType === null) {
                    $this->writeUsage();

                    return 1;
                }

                $databaseType = $requestedDatabaseType;

                continue;
            }

            if (\str_starts_with($argument, '--') || $source !== null) {
                $this->writeUsage();

                return 1;
            }

            $source = $argument;
        }

        if ($source === null) {
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

        $parserClass = $this->resolveParserClass($source);

        if ($parserClass === null) {
            $this->writeUsage();

            return 1;
        }

        if (!\class_exists($parserClass)) {
            $this->writeError(\sprintf('Parser %s is not available.', $parserClass));

            return 1;
        }

        if (!\is_a($parserClass, ParserInterface::class, true)) {
            $this->writeError(\sprintf('Parser %s does not implement %s.', $parserClass, ParserInterface::class));

            return 1;
        }

        try {
            /** @var ParserInterface $parser */
            $parser = new $parserClass();
            $columns = $parser->parse($source, $databaseType);

            $this->writeColumns($columns);

            return 0;
        } catch (\Throwable $throwable) {
            $this->writeError(\sprintf('Error: %s', $throwable->getMessage()));

            return 1;
        }
    }

    private function isHttpSource(string $source): bool
    {
        return \str_starts_with($source, 'http://') || \str_starts_with($source, 'https://');
    }

    private function resolveParserClass(string $source): ?string
    {
        $extension = \strtolower(\pathinfo($source, \PATHINFO_EXTENSION));

        if ($extension === '') {
            return null;
        }

        return $this->parserClasses[$extension] ?? null;
    }

    private function writeUsage(): void
    {
        $this->writeToStream(
            $this->stderr,
            'Usage: infer-data-schema <path-or-url> [--db=sqlite|mysql|sqlserver]' . \PHP_EOL
        );
    }

    private function writeColumns(SqlColumnCollectionInterface $columns): void
    {
        foreach ($columns->getColumns() as $column) {
            $this->writeToStream($this->stdout, $this->formatColumn($column) . \PHP_EOL);
        }
    }

    private function formatColumn(SqlColumnInterface $column): string
    {
        $modifiers = \implode(
            ', ',
            \array_map(
                static fn (ColumnModifier $modifier): string => $modifier->value,
                $column->getModifiers(),
            )
        );

        if ($modifiers === '') {
            return \sprintf('%s %s', $column->getName(), $column->getType());
        }

        return \sprintf('%s %s %s', $column->getName(), $column->getType(), $modifiers);
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
