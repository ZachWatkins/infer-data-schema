<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Parsers;

use ZachWatkins\InferDataSchema\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\Interfaces\ColumnTypeInferrerInterface;
use ZachWatkins\InferDataSchema\Interfaces\ParserInterface;
use ZachWatkins\InferDataSchema\Interfaces\SqlColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Support\ColumnTypeInferrer;

use function Flow\ETL\Adapter\Excel\DSL\from_excel;
use function Flow\ETL\DSL\data_frame;

final class ExcelParser implements ParserInterface
{
    public function __construct(
        private readonly ColumnTypeInferrerInterface $inferrer = new ColumnTypeInferrer(),
    ) {}

    public function parse(
        string $source,
        string $databaseType = 'sqlite',
    ): SqlColumnCollectionInterface {
        if (!in_array($databaseType, array_map(fn($case) => $case->value, DatabaseType::cases()), true)) {
            throw new \InvalidArgumentException("Invalid database type: $databaseType, accepts: " . implode(', ', array_map(fn($case) => $case->value, DatabaseType::cases())));
        }
        $databaseType = DatabaseType::from($databaseType);
        $rows = data_frame()->read(from_excel($source))->getEachAsArray();

        return $this->inferrer->infer($rows, $databaseType);
    }
}
