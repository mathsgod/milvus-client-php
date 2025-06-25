<?php

namespace Milvus\Field;

use Milvus\FieldInterface;
use Milvus\DataType;

class ScalarField implements FieldInterface
{
    private string $fieldName;
    private string $dataType;
    private bool $nullable = false;
    private ?string $description;
    private ?int $max_length = null;

    public function __construct(string $fieldName, string $dataType, ?int $max_length = null, ?string $description = null)
    {
        $this->fieldName = $fieldName;
        $this->dataType = $dataType;
        $this->max_length = $max_length;
        $this->description = $description;
    }

    public function toArray(): array
    {
        $arr = [
            'fieldName' => $this->fieldName,
            'dataType' => $this->dataType,
            'description' => $this->description,
        ];

        if ($this->nullable) {
            $arr['nullable'] = true;
        }

        if ($this->dataType === DataType::VARCHAR && $this->max_length !== null) {
            $arr['elementTypeParams'] = [
                'max_length' =>  $this->max_length
            ];
        }
        return $arr;
    }
}
