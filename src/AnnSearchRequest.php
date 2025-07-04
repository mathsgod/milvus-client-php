<?php

namespace Milvus;

use JsonSerializable;

class AnnSearchRequest implements JsonSerializable
{

    public function __construct(
        private array $data,
        private string $anns_field,
        private array $param,
        private int $limit
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'data' => $this->data,
            'annsField' => $this->anns_field,
            'limit' => $this->limit,
            "outputFields" => ["*"]
        ];
    }
}
