<?php

namespace Milvus\Field;

use Milvus\FieldInterface;

class PrimaryField implements FieldInterface
{
    private string $fieldName;
    private string $dataType;
    private ?string $description;

    public function __construct(string $fieldName, string $dataType, ?string $description = null)
    {
        $this->fieldName = $fieldName;
        $this->dataType = $dataType;
        $this->description = $description;
    }

    public function toArray(): array
    {
        return [
            'fieldName' => $this->fieldName,
            'dataType' => $this->dataType,
            'isPrimary' => true,
            'description' => $this->description,
        ];
    }
}
