<?php

namespace Milvus;

use Milvus\Field\PrimaryField;
use Milvus\Field\VectorField;
use Milvus\Field\ScalarField;

class Schema
{
    private $fields = [];
    private $autoID;

    public function __construct($autoID)
    {
        $this->autoID = $autoID;
        $this->fields = [];
    }

    public function toArray()
    {
        return [
            'autoID' => $this->autoID,
            'fields' => $this->fields
        ];
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function addPrimaryField(string $fieldName, string $dataType, ?string $description = null)
    {
        // 僅允許 Int64 或 VarChar
        if ($dataType !== 'Int64' && $dataType !== 'VarChar') {
            throw new \InvalidArgumentException('Primary field only supports Int64 or VarChar types.');
        }
        $this->fields[] = new PrimaryField($fieldName, $dataType, $description);
        return $this;
    }

    public function addVectorField(string $fieldName, string $dataType, int $dimension, ?string $description = null)
    {
        $this->fields[] = new VectorField($fieldName, $dataType, $dimension, $description);
        return $this;
    }

    public function addScalarField(string $fieldName, string $dataType, ?string $description = null)
    {
        $this->fields[] = new ScalarField($fieldName, $dataType, $description);
        return $this;
    }
}
