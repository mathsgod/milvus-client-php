<?php

namespace Milvus;

class CollectionSchema implements \JsonSerializable
{
    private $functions = [];

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
        $fields = array_map(function (array $field): array {
            if ($this->primary_field !== null && $field['fieldName'] === $this->primary_field) {
                $field['isPrimary'] = true;
            }

            if ($this->partition_key_field !== null && $field['fieldName'] === $this->partition_key_field) {
                $field['isPartitionKey'] = true;
            }

            return $field;
        }, $this->fields);

        $data = [
            'autoID' => $this->auto_id,
            "enableDynamicField" => $this->enable_dynamic_field,
            'fields' => $fields,
        ];

        if ($this->functions) {
            $data['functions'] = $this->functions;
        }

        //print_R($data);die;
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

        if (in_array($datatype, [
            DataType::INT8_VECTOR,
            DataType::FLOAT_VECTOR,
            DataType::BINARY_VECTOR,
            DataType::FLOAT16_VECTOR,
            DataType::BFLOAT16_VECTOR,
        ], true)) {
            if ($dim === null) {
                throw new \InvalidArgumentException('Dimension must be specified for vector fields.');
            }
        }

        $field = array_filter([
            "fieldName" => $field_name,
            "dataType" => $datatype,
            "elementDataType" => $element_type,
            "nullable" => $nullable,
            "isPrimary" => $is_primary,
            "isPartitionKey" => $is_partition_key,
            "isClusteringKey" => $is_clustering_key,
        ], fn ($value) => $value !== null);

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

    public function addFunction(
        string $name,
        string $function_type,
        array $input_field_names,
        array $output_field_names,
        array $params = [],
        ?string $description = null
    )
    {

        $function = [
            "name" => $name,
            "type" => $function_type,
            "inputFieldNames" => $input_field_names,
            "outputFieldNames" => $output_field_names,
            "params" => $params,
        ];

        if ($description !== null) {
            $function['description'] = $description;
        }

        //filter out empty params
        if (count($function['params']) === 0) {
            unset($function['params']);
        }


        $this->functions[] = $function;

        return $this;
    }
}
