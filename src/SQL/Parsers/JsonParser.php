<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\SQL\Parsers;

use ZachWatkins\InferDataSchema\SQL\Enums\DatabaseType;
use ZachWatkins\InferDataSchema\SQL\Interfaces\ColumnTypeInferrerInterface;
use ZachWatkins\InferDataSchema\SQL\Interfaces\ParserInterface;
use ZachWatkins\InferDataSchema\SQL\Interfaces\SQLColumnCollectionInterface;
use ZachWatkins\InferDataSchema\SQL\ColumnTypeInferrer;

use function Flow\ETL\Adapter\JSON\from_json;
use function Flow\ETL\DSL\data_frame;

final class JsonParser implements ParserInterface
{
    public function __construct(
        private readonly ColumnTypeInferrerInterface $inferrer = new ColumnTypeInferrer(),
    ) {}

    public function parse(
        string $source,
        string $databaseType = 'sqlite',
    ): SQLColumnCollectionInterface {
        if (!in_array($databaseType, array_map(fn($case) => $case->value, DatabaseType::cases()), true)) {
            throw new \InvalidArgumentException("Invalid database type: $databaseType, accepts: " . implode(', ', array_map(fn($case) => $case->value, DatabaseType::cases())));
        }
        $databaseType = DatabaseType::from($databaseType);
        $rows = data_frame()
            ->read(from_json($source))
            ->getEachAsArray();

        return $this->inferrer->infer($rows, $databaseType);
    }
}
