<?php

declare(strict_types=1);

namespace ZachWatkins\InferLaravelBlueprint;

use Http\Client\Curl\Client as CurlClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Enums\BlueprintConfigResource;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Interfaces\BlueprintParserInterface;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Lexers\BlueprintFileLexer;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Models\BlueprintConfig;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Models\BlueprintModel;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Parsers\HttpParser as BlueprintHttpParser;
use ZachWatkins\InferLaravelBlueprint\Blueprint\Parsers\HttpResponseSizeLimitException;
use ZachWatkins\InferLaravelBlueprint\SQL\Enums\ColumnModifier;
use ZachWatkins\InferLaravelBlueprint\SQL\Enums\DatabaseType;
use ZachWatkins\InferLaravelBlueprint\SQL\Interfaces\ParserInterface as SQLParserInterface;
use ZachWatkins\InferLaravelBlueprint\SQL\Interfaces\SQLColumnCollectionInterface;
use ZachWatkins\InferLaravelBlueprint\SQL\Interfaces\SQLColumnInterface;

final class Console
{
    public const HELP = 'Infer a Laravel Shift Blueprint file from various data sources. By Zach Watkins.
Usage: {filename} [--cwd=<current-working-directory>] [--db=sqlite|mysql|sqlserver] [--format=sql,blueprint] [--blueprint-model=<name>] [--blueprint-view=blade|inertia] [--blueprint-resource=web,api,index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy] [--blueprint-controller-methods=index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy,<custom>] [--blueprint-seeders] [--http-header=<name>:<value>] [--http-timeout=<seconds>] [--save] [--dry-run] [--help] <path-or-url>

Options:
  [--db=]                 Database type. Accepts: sqlite, mysql, sqlserver.
                          Default: mysql.
  [--cwd=]                Set the current working directory.
  [--dry-run]             Perform a trial run without making any changes.
  [--format=]             Output format. Accepts: sql, blueprint.
                          Default: blueprint.
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
  [--http-header=]        Add a request header for an HTTP Blueprint source.
                          May be specified more than once.
  [--http-timeout=]       Set the timeout in seconds for each HTTP request.
                          Default: 30 seconds. Accepts: 1-3600.
  [--save]                Save the output to a file.
  [--help]                Display this help message.
';

    private const DEFAULT_HTTP_TIMEOUT = 30;

    private const MAX_HTTP_RESPONSE_BYTES = 67108864;

    /**
     * @var list<string>
     */
    private const CREDENTIAL_HTTP_HEADERS = [
        'authorization',
        'proxy-authorization',
        'cookie',
    ];

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

    private ?ClientInterface $httpClient;

    /**
     * @param  resource|null  $stdout
     * @param  resource|null  $stderr
     * @param  array<string, class-string>|null  $parserClasses
     * @param  ClientInterface|null  $httpClient  Optional PSR-18 client for HTTP sources.
     */
    public function __construct($stdout = null, $stderr = null, ?array $parserClasses = null, ?ClientInterface $httpClient = null)
    {
        $this->stdout = $stdout ?? \STDOUT;
        $this->stderr = $stderr ?? \STDERR;
        $this->httpClient = $httpClient;
        $this->parserClasses = $parserClasses ?? [
            'sql' => [
                'csv' => '\ZachWatkins\InferLaravelBlueprint\SQL\Parsers\CsvParser',
                'json' => '\ZachWatkins\InferLaravelBlueprint\SQL\Parsers\JsonParser',
                'xml' => '\ZachWatkins\InferLaravelBlueprint\SQL\Parsers\XmlParser',
                'xlsx' => '\ZachWatkins\InferLaravelBlueprint\SQL\Parsers\ExcelParser',
                'xls' => '\ZachWatkins\InferLaravelBlueprint\SQL\Parsers\ExcelParser',
                'ods' => '\ZachWatkins\InferLaravelBlueprint\SQL\Parsers\ExcelParser',
            ],
            'blueprint' => [
                'csv' => '\ZachWatkins\InferLaravelBlueprint\Blueprint\Parsers\CsvParser',
                'json' => '\ZachWatkins\InferLaravelBlueprint\Blueprint\Parsers\JsonParser',
                'xml' => '\ZachWatkins\InferLaravelBlueprint\Blueprint\Parsers\XmlParser',
                'xlsx' => '\ZachWatkins\InferLaravelBlueprint\Blueprint\Parsers\ExcelParser',
                'xls' => '\ZachWatkins\InferLaravelBlueprint\Blueprint\Parsers\ExcelParser',
                'ods' => '\ZachWatkins\InferLaravelBlueprint\Blueprint\Parsers\ExcelParser',
            ],
        ];

        $runningPhar = \Phar::running(false);
        if ($runningPhar !== '') {
            if ($runningPhar === 'infer-laravel-blueprint') {
                $this->filename = basename($runningPhar);
            }
        } elseif (isset($_SERVER['argv'][0]) && ! empty($_SERVER['argv'][0]) && basename($_SERVER['argv'][0]) === 'infer-laravel-blueprint') {
            $this->filename = basename($_SERVER['argv'][0]);
        }
    }

    /**
     * @param  array<int, string>  $argv
     */
    public function run(array $argv): int
    {
        $source = null;
        $databaseType = DatabaseType::MySQL;
        $currentWorkingDirectory = getcwd();
        $dryRun = false;
        $format = 'blueprint';
        $blueprintOptions = [
            'model' => null,
            'seeders' => false,
            'view' => null,
            'methods' => [],
            'resources' => [],
        ];
        /** @var list<array{string, string}> $httpHeaders */
        $httpHeaders = [];
        $httpTimeout = self::DEFAULT_HTTP_TIMEOUT;
        $save = false;

        foreach (\array_slice($argv, 1) as $argument) {
            if (\str_starts_with($argument, '--help')) {
                $this->writeUsage();

                return 0;
            }

            if (\str_starts_with($argument, '--db=')) {
                $requestedDatabaseType = DatabaseType::tryFrom(\strtolower(\substr($argument, 5)));

                if ($requestedDatabaseType === null) {
                    $this->writeUsage('Error: Invalid database type specified: '.\substr($argument, 5));

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

                if (! \in_array($requestedFormat, ['sql', 'blueprint'], true)) {
                    $this->writeUsage('Error: Invalid format specified: '.$requestedFormat);

                    return 1;
                }

                $format = $requestedFormat;

                continue;
            }

            if (\str_starts_with($argument, '--blueprint-model=')) {
                $blueprintOptions['model'] = \substr($argument, 18);

                continue;
            }

            if (\str_starts_with($argument, '--http-header=')) {
                $header = \substr($argument, 14);
                $separator = \strpos($header, ':');
                $name = $separator === false ? '' : \trim(\substr($header, 0, $separator));
                $value = $separator === false ? '' : \trim(\substr($header, $separator + 1));

                if (\in_array(\strtolower($name), self::CREDENTIAL_HTTP_HEADERS, true)) {
                    $this->writeUsage('Error: Credential HTTP headers are not allowed.');

                    return 1;
                }

                if (\preg_match('/^[!#$%&\'*+.^_`|~0-9A-Za-z-]+$/', $name) !== 1 || \preg_match('/[\r\n]/', $value) === 1) {
                    $this->writeUsage('Error: Invalid HTTP header. Use --http-header=<name>:<value>.');

                    return 1;
                }

                $httpHeaders[] = [$name, $value];

                continue;
            }

            if (\str_starts_with($argument, '--http-timeout=')) {
                $requestedTimeout = \filter_var(\substr($argument, 15), \FILTER_VALIDATE_INT);
                if (! \is_int($requestedTimeout) || $requestedTimeout < 1 || $requestedTimeout > 3600) {
                    $this->writeUsage('Error: HTTP timeout must be an integer between 1 and 3600 seconds.');

                    return 1;
                }

                $httpTimeout = $requestedTimeout;

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
                $this->writeUsage('Error: Unexpected argument: '.$argument);

                return 1;
            }

            $source = $argument;
        }

        if ($source === null) {
            $this->writeUsage('Error: Source is not specified.');

            return 1;
        }

        $isHttpSource = $this->isHttpSource($source);

        if ($isHttpSource) {
            if ($format !== 'blueprint') {
                $this->writeError(
                    'HTTP sources are supported only with --format=blueprint.'
                );

                return 1;
            }
        } else {
            if (! \str_starts_with($source, '/') && ! \preg_match('/^[a-zA-Z]:\\\\/', $source)) {
                if (! file_exists($source)) {
                    if (is_string($currentWorkingDirectory) && ! empty($currentWorkingDirectory)) {
                        $resolved = $currentWorkingDirectory.\DIRECTORY_SEPARATOR.$source;
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
                } elseif (! is_string($currentWorkingDirectory) || empty($currentWorkingDirectory)) {
                    $currentWorkingDirectory = \dirname($source);
                }
            } elseif (! file_exists($source)) {
                $this->writeError(sprintf('File path \'%s\' could not be found.', $source));

                return 1;
            } elseif (! is_string($currentWorkingDirectory) || empty($currentWorkingDirectory)) {
                $currentWorkingDirectory = \dirname($source);
            }
        }

        $parserClass = $this->resolveParserClass($format, $source);

        if ($parserClass === null) {
            $this->writeUsage('Error: Unable to resolve parser class for the specified format and source.');

            return 1;
        }

        if (! \class_exists($parserClass)) {
            $this->writeError(\sprintf('Parser %s is not available.', $parserClass));

            return 1;
        }

        if (\is_a($parserClass, SQLParserInterface::class, true)) {
            /** @var SQLParserInterface $parser */
            $parser = new $parserClass;
            $columns = $parser->parse($source, $databaseType->value);

            if (! $dryRun) {
                $this->writeSQLColumns($columns);
            }
        } elseif (\is_a($parserClass, BlueprintParserInterface::class, true)) {
            if (! is_string($blueprintOptions['model']) || empty($blueprintOptions['model'])) {
                $this->writeError('Error: The --blueprint-model option must be provided and must be a non-empty string.');

                return 1;
            }
            /** @var BlueprintParserInterface $parser */
            if ($isHttpSource) {
                $maxResponseBytes = $this->maxHttpResponseBytes();
                $parser = new BlueprintHttpParser(
                    $this->httpClient ?? $this->createHttpClient($httpTimeout, $maxResponseBytes),
                    parser: new $parserClass,
                    sourceExtension: $this->sourceExtension($source) ?? 'json',
                    accept: $this->resolveHttpAccept($this->sourceExtension($source) ?? 'json'),
                    headers: $httpHeaders,
                    maxResponseBytes: $maxResponseBytes,
                );
            } else {
                $parser = new $parserClass;
            }

            try {
                $columns = $parser->parse($source);
            } catch (HttpResponseSizeLimitException|ClientExceptionInterface $exception) {
                $this->writeError($exception->getMessage());

                return 1;
            }
            $model = new BlueprintModel($blueprintOptions['model'], $columns);

            if (! $dryRun) {
                $lexer = new BlueprintFileLexer;
                $blueprintContent = $lexer->toString(
                    new BlueprintConfig(
                        models: [$model],
                        resources: $blueprintOptions['resources'],
                        methods: $blueprintOptions['methods'],
                        seeders: $blueprintOptions['seeders'],
                        view: $blueprintOptions['view'],
                    )
                );
                if (! $save) {
                    $this->writeToStream(
                        $this->stdout,
                        $blueprintContent
                    );
                } else {
                    $outputDirectory = realpath($currentWorkingDirectory ?? getcwd());
                    if ($outputDirectory === false) {
                        $this->writeError('Error: Unable to resolve the output directory.');

                        return 1;
                    }
                    $destinationPath = $outputDirectory.DIRECTORY_SEPARATOR.$model->tableNameSingular.'-blueprint.yaml';
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
        $source = \strtolower($source);

        return \str_starts_with($source, 'http://') || \str_starts_with($source, 'https://');
    }

    /**
     * Resolves a source extension, using the URL path rather than its query string.
     */
    private function sourceExtension(string $source): ?string
    {
        $path = $this->isHttpSource($source) ? \parse_url($source, \PHP_URL_PATH) : $source;
        $extension = \strtolower(\pathinfo(\is_string($path) ? $path : $source, \PATHINFO_EXTENSION));

        return $extension === '' ? null : $extension;
    }

    /**
     * Resolves the default media type requested for a supported HTTP source extension.
     */
    private function resolveHttpAccept(string $extension): string
    {
        return match ($extension) {
            'csv' => 'text/csv',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls' => 'application/vnd.ms-excel',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            default => 'application/octet-stream',
        };
    }

    /**
     * Creates the default PSR-18 transport used for CLI HTTP requests.
     */
    private function createHttpClient(int $timeout, int $maxResponseBytes): ClientInterface
    {
        $factory = new Psr17Factory;

        return new CurlClient($factory, $factory, [
            \CURLOPT_CONNECTTIMEOUT => $timeout,
            \CURLOPT_MAXFILESIZE_LARGE => $maxResponseBytes,
            \CURLOPT_TIMEOUT => $timeout,
        ]);
    }

    /**
     * Limits response bodies to at most one quarter of PHP's memory limit, capped at 64 MiB.
     */
    private function maxHttpResponseBytes(): int
    {
        $memoryLimit = \ini_get('memory_limit');
        if (! \is_string($memoryLimit) || $memoryLimit === '' || $memoryLimit === '-1') {
            return self::MAX_HTTP_RESPONSE_BYTES;
        }

        $memoryLimitBytes = \ini_parse_quantity($memoryLimit);
        if ($memoryLimitBytes <= 0) {
            return self::MAX_HTTP_RESPONSE_BYTES;
        }

        $availableMemoryBytes = $memoryLimitBytes - \memory_get_usage(true);
        if ($availableMemoryBytes <= 0) {
            return 1;
        }

        return \min(self::MAX_HTTP_RESPONSE_BYTES, \max(1, \intdiv($availableMemoryBytes, 4)));
    }

    private function resolveParserClass(string $format, string $source): ?string
    {
        $extension = $this->sourceExtension($source) ?? ($this->isHttpSource($source) ? 'json' : null);

        if ($extension === null) {
            return null;
        }

        return $this->parserClasses[$format][$extension] ?? null;
    }

    private function writeUsage(string $message = ''): void
    {
        $output = str_replace('{filename}', $this->filename, self::HELP);
        if ($message) {
            $output = $message."\n".$output;
        }
        $this->writeToStream(
            $this->stderr,
            $output
        );
    }

    private function writeSQLColumns(SQLColumnCollectionInterface $columns): void
    {
        foreach ($columns->getColumns() as $column) {
            $this->writeToStream($this->stdout, $this->formatSQLColumn($column)."\n");
        }
    }

    private function formatSQLColumn(SQLColumnInterface $column): string
    {
        $modifiers = \implode(
            ' ',
            \array_map(
                static fn (ColumnModifier $modifier): string => $modifier->value,
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
        $this->writeToStream($this->stderr, $message."\n");
    }

    /**
     * @param  resource  $stream
     */
    private function writeToStream($stream, string $message): void
    {
        \fwrite($stream, $message);
    }
}
