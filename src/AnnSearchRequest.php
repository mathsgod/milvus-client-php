<?php

namespace Milvus;

use JsonSerializable;

class AnnSearchRequest implements JsonSerializable
{

    public function __construct(
        private array $data,
        private string $anns_field,
        private array $param,
        private int $limit,
        private ?string $filter = null,
    ) {}

    public function jsonSerialize(): array
    {
        $json = [
            'data' => $this->data,
            'annsField' => $this->anns_field,
            'limit' => $this->limit,
            "outputFields" => ["*"]
        ];
        if (isset($this->filter)) {
            $json['filter'] = $this->filter;
        }
        if (isset($this->param['groupingField'])) {
            $json['groupingField'] = $this->param['groupingField'];
        }
        if (isset($this->param['metric_type'])) {
            $json['metricType'] = $this->param['metric_type'];
        }

        if (isset($this->param['limit'])) {
            $json['limit'] = $this->param['limit'];
        }

        if (isset($this->param['offset'])) {
            $json['offset'] = $this->param['seaoffsetrchParams'];
        }

        if (isset($this->param['ignoreGrowing'])) {
            $json['ignoreGrowing'] = $this->param['ignoreGrowing'];
        }

        if (isset($this->param['params'])) {
            $json['params'] = $this->param['params'];
        }



        return $json;
    }
}
