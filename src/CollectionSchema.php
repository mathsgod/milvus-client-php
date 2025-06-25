<?php

namespace Milvus;

use Milvus\Field\PrimaryField;
use Milvus\Field\VectorField;
use Milvus\Field\ScalarField;

class CollectionSchema
{
    private $fields = [];
    private bool $auto_id;
    private bool $enable_dynamic_field;

    public function __construct(bool $auto_id = false, bool $enable_dynamic_field = false)
    {
        $this->auto_id = $auto_id;
        $this->enable_dynamic_field = $enable_dynamic_field;

        $this->fields = [];
    }



    public function toArray()
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


    public function addField(
        string $field_name,
        string $datatype,
        bool $is_primary = false,
        int $max_lenght = 0,
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
            return $this->addScalarField($field_name, $datatype, $max_lenght);
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
