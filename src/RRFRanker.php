<?php

namespace Milvus;

use JsonSerializable;

class RRFRanker implements JsonSerializable 
{
    public function __construct(
        protected int $k
    ) {}

    public function jsonSerialize(): array
    {
        return [
            "strategy" => "rrf",
            "params" => [
                "k" => $this->k
            ]
        ];
    }
}
