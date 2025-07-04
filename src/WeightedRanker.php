<?php

namespace Milvus;

class WeightedRanker implements \JsonSerializable
{
    public function __construct(
        protected array $weights
    ) {}

    public function jsonSerialize(): array
    {
        return [
            "strategy" => "weighted",
            "params" => [
                "weights" => $this->weights
            ]
        ];
    }
}
