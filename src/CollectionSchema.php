<?php

namespace Milvus;

use Milvus\Field\PrimaryField;
use Milvus\Field\VectorField;
use Milvus\Field\ScalarField;

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
            return $this->addPrimaryField($field_name, $datatype);
        }

        if ($datatype == DataType::INT8_VECTOR || $datatype == DataType::FLOAT_VECTOR) {
            if ($dim === null) {
                throw new \InvalidArgumentException('Dimension must be specified for vector fields.');
            }
            return $this->addVectorField($field_name, $datatype, $dim);
        }


        if ($datatype === DataType::INT64 || $datatype === DataType::VARCHAR) {
            return $this->addScalarField($field_name, $datatype, $max_length); // corrected 'max_lenght' to 'max_length'
        }
    }

    private function addPrimaryField(string $fieldName, string $dataType, ?string $description = null)
    {
        // 僅允許 Int64 或 VarChar
        if ($dataType !== 'Int64' && $dataType !== 'VarChar') {
            throw new \InvalidArgumentException('Primary field only supports Int64 or VarChar types.');
        }
        $this->fields[] = new PrimaryField($fieldName, $dataType, $description);
        return $this;
    }

    private function addVectorField(string $fieldName, string $dataType, int $dimension, ?string $description = null)
    {
        $this->fields[] = new VectorField($fieldName, $dataType, $dimension, $description);
        return $this;
    }

    private function addScalarField(string $fieldName, string $dataType, int $max_length = 0, ?string $description = null)
    {
        $this->fields[] = new ScalarField($fieldName, $dataType, $max_length, $description);
        return $this;
    }
}
