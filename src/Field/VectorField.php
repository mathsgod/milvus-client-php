<?php

namespace Milvus\Field;

class VectorField
{
    private string $fieldName;
    private string $dataType;
    private int $dimension;
    private ?string $description;

    public function __construct(string $fieldName, string $dataType, int $dimension, ?string $description = null)
    {
        $this->fieldName = $fieldName;
        $this->dataType = $dataType;
        $this->dimension = $dimension;
        $this->description = $description;
    }

    public function toArray(): array
    {
        return [
            'fieldName' => $this->fieldName,
            'dataType' => $this->dataType,
            "elementTypeParam" => [
                "dim" => $this->dimension,
            ],
            'description' => $this->description,
        ];
    }
}
