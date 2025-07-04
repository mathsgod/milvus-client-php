<?php

namespace Milvus;

class CollectionSchema implements \JsonSerializable
{

    public function __construct(
        private array $fields = [],
        private ?bool $auto_id = null,
        private ?bool $enable_dynamic_field = null,
        private ?string $description = null,
        private ?string $primary_field = null,
        private ?string $partition_key_field = null,
    ) {}

    public function jsonSerialize(): mixed
    {
        $data = [
            'autoID' => $this->auto_id,
            "enabledDynamicField" => $this->enable_dynamic_field,
            'fields' => $this->fields,
        ];

        return array_filter($data, fn($value) => $value !== null);
    }

    public function addField(
        string $field_name, //The name of the field.
        string $datatype, //The data type of the field.
        ?bool $is_primary = null,
        ?int $max_length = null,
        ?string $element_type = null,
        ?int $max_capacity = null,
        ?int $dim = null,
        ?bool $is_partition_key = null,
        ?bool $is_clustering_key = null,
        ?bool $mmap_enabled = null,
        ?bool $nullable = null,
        ?bool $enable_analyzer = null,
        ?bool $enable_match = null,
        ?array $analyzer_params = null
    ) {

        if ($datatype == DataType::INT8_VECTOR || $datatype == DataType::FLOAT_VECTOR) {
            if ($dim === null) {
                throw new \InvalidArgumentException('Dimension must be specified for vector fields.');
            }
        }

        $field = [
            "fieldName" => $field_name,
            "dataType" => $datatype,
            "autoId" => false,
            "elementDataType" => $element_type,
            "nullable" => $nullable,
            "isPrimary" => $is_primary,
            "isPartitionKey" => $is_partition_key,
            "isClusteringKey" => $is_clustering_key,
        ];

        $elementTypeParams = [];

        if ($dim !== null) {
            $elementTypeParams["dim"] = $dim;
        }

        if ($max_length !== null) {
            $elementTypeParams["max_length"] = $max_length;
        }

        if ($max_capacity !== null) {
            $elementTypeParams["max_capacity"] = $max_capacity;
        }

        if ($enable_analyzer !== null) {
            $elementTypeParams["enable_analyzer"] = $enable_analyzer;
        }

        if ($enable_match !== null) {
            $elementTypeParams["enable_match"] = $enable_match;
        }

        if ($analyzer_params !== null) {
            $elementTypeParams["analyzer_params"] = $analyzer_params;
        }

        if (!empty($elementTypeParams)) {
            $field["elementTypeParams"] = $elementTypeParams;
        }

        $this->fields[] = $field;


        return $this;
    }
}
