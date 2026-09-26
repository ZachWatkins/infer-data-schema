<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Blueprint\Parsers;

use ZachWatkins\InferDataSchema\Blueprint\Inferers\BlueprintColumnTypeInferrer;
use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintColumnCollectionInterface;
use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintColumnTypeInferrerInterface;
use ZachWatkins\InferDataSchema\Blueprint\Interfaces\BlueprintParserInterface;

use function Flow\ETL\Adapter\JSON\from_json;
use function Flow\ETL\DSL\data_frame;

final class JsonParser implements BlueprintParserInterface
{
    public function __construct(
        private readonly BlueprintColumnTypeInferrerInterface $inferrer = new BlueprintColumnTypeInferrer,
    ) {}

    public function parse(
        string $source,
    ): BlueprintColumnCollectionInterface {
        $rows = data_frame()
            ->read(from_json($source))
            ->getEachAsArray();

        return $this->inferrer->infer($rows);
    }
}
