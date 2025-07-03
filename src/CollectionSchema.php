<?php

namespace Milvus;

class CollectionSchema implements \JsonSerializable
{
    private $fields = [];
    private bool $auto_id;
    private bool $enable_dynamic_field;
    private string $description;

    public function __construct(
        array $fields = [],
        string $description,
        bool $auto_id = false,
        bool $enable_dynamic_field = false
    ) {
        $this->fields = $fields;
        $this->description = $description;
        $this->auto_id = $auto_id;
        $this->enable_dynamic_field = $enable_dynamic_field;

        $this->fields = [];
    }

    public function jsonSerialize(): mixed
    {
        return [
            'autoID' => $this->auto_id,
            "enabledDynamicField" => $this->enable_dynamic_field,
            'fields' => array_map(function ($field) {
                return $field->toArray();
            }, $this->fields)
        ];
    }

    public function getFields()
    {
        return $this->fields;
    }


    public function add_field(
        string $field_name,
        string $datatype,
        bool $is_primary = false,
        int $max_length = 0, // corrected spelling from 'max_lenght' to 'max_length'
        ?string $element_type = null,
        ?int $max_capacity = null,
        ?int $dim = null,
        bool $is_partition_key = false,
        bool $is_clustering_key = false,
        bool $mmap_enabled = false
    ) {

        if ($is_primary) {

            $this->fields[] = new FieldSchema(
                $field_name,
                $datatype,
                null, // description
                true, // is_primary
                $this->auto_id, // auto_id
                $is_partition_key, // is_partition_key
                $max_length, // max_length
                $dim // dim
            );
            return $this;
        }

        if ($datatype == DataType::INT8_VECTOR || $datatype == DataType::FLOAT_VECTOR) {
            if ($dim === null) {
                throw new \InvalidArgumentException('Dimension must be specified for vector fields.');
            }

            $this->fields[] = new FieldSchema(
                $field_name,
                $datatype,
                null, // description
                false, // is_primary
                $this->auto_id, // auto_id
                $is_partition_key, // is_partition_key
                $max_length, // max_length
                $dim // dim
            );
        }

        if ($datatype === DataType::INT64 || $datatype === DataType::VARCHAR) {

            $this->fields[] = new FieldSchema(
                $field_name,
                $datatype,
                null, // description
                false, // is_primary
                $this->auto_id, // auto_id
                $is_partition_key, // is_partition_key
                $max_length, // max_length
                null // dim
            );
        }
    }
}
