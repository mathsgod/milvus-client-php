<?php

namespace Milvus\Field;

use Milvus\FieldInterface;

class VectorField implements FieldInterface
{
    private string $fieldName;
    private string $dataType;
    private int $dim;
    private ?string $description;

    public function __construct(string $fieldName, string $dataType, int $dim, ?string $description = null)
    {
        $this->fieldName = $fieldName;
        $this->dataType = $dataType;
        $this->dim = $dim;
        $this->description = $description;
    }

    public function toArray(): array
    {
        return [
            'fieldName' => $this->fieldName,
            'dataType' => $this->dataType,
            "elementTypeParams" => [
                "dim" =>  $this->dim,
            ],
            'description' => $this->description,
        ];
    }
}
