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
        return [
            'autoID' => $this->auto_id,
            "enabledDynamicField" => $this->enable_dynamic_field,
            'fields' => array_map(function ($field) {
                return $field->jsonSerialize();
            }, $this->fields)
        ];
    }

    public function getFields()
    {
        return $this->fields;
    }


    public function addField(
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
