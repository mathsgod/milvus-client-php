<?php

namespace Milvus;

class IndexParams implements \JsonSerializable
{
    private $indexes = [];

    public function addIndex(
        ?string $field_name = null,
        ?string $index_name = null,
        ?string $index_type = null,
        ?string $metric_type = null,
        ?array $params = null
    ) {

        $index = [
            'fieldName' => $field_name,
            'indexName' => $index_name,
            'indexType' => $index_type,
            'metricType' => $metric_type,
            'params' => $params,
        ];

        // Remove null values
        $index = array_filter($index, function ($value) {
            return !is_null($value);
        });

        $this->indexes[] = $index;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return $this->indexes;
    }
}
