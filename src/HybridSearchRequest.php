<?php

namespace Milvus;

use JsonSerializable;

class HybridSearchRequest implements JsonSerializable
{

    public function __construct(
        private array $data, //A list of vector embeddings. Milvus searches for the most similar vector embeddings to the specified ones.
        private string $anns_field,
        private int $limit,
        private ?int $offset = null,
        private ?bool $ignore_growing = null,
        private ?string $metric_type = null,
        private ?string $filter = null,
        private ?string $grouping_field = null,
        private ?array $param = null
    ) {}

    public function jsonSerialize(): array
    {
        $json = [
            'data' => $this->data,
            'annsField' => $this->anns_field,
            'filter' => $this->filter,
            'groupingField' => $this->grouping_field,
            'limit' => $this->limit,
            'offset' => $this->offset,
            "outputFields" => ["*"],
            'metricType' => $this->metric_type,
            'ignoreGrowing' => $this->ignore_growing,
            'params' => $this->param,
        ];

        //filter out null values
        $json = array_filter($json, function ($value) {
            return !is_null($value);
        });

        return $json;
    }
}
