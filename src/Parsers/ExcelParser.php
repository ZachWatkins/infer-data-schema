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
    ) {
    }

    public function parse(
        string $source,
        DatabaseType $databaseType = DatabaseType::Sqlite,
    ): SqlColumnCollectionInterface {
        $rows = data_frame()->read(from_excel($source))->getEachAsArray();

        return $this->inferrer->infer($rows, $databaseType);
    }
}
