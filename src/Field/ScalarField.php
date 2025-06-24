<?php

namespace Milvus\Field;

class ScalarField
{
    // 支援型別常數
    public const TYPE_VARCHAR = 'VarChar';
    public const TYPE_BOOLEAN = 'Boolean';
    public const TYPE_INT = 'Int';
    public const TYPE_FLOAT = 'Float';
    public const TYPE_DOUBLE = 'Double';
    public const TYPE_ARRAY = 'Array';
    public const TYPE_JSON = 'JSON';

    private string $fieldName;
    private string $dataType;
    private bool $isPrimary = false;
    private bool $isNullable = true;
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
            'isPrimary' => $this->isPrimary,
            'isNullable' => $this->isNullable,
            'description' => $this->description,
        ];
    }

    // 靜態工廠方法
    public static function varchar(string $fieldName, ?string $description = null): self
    {
        return new self($fieldName, self::TYPE_VARCHAR, $description);
    }

    public static function boolean(string $fieldName, ?string $description = null): self
    {
        return new self($fieldName, self::TYPE_BOOLEAN, $description);
    }

    public static function int(string $fieldName, ?string $description = null): self
    {
        return new self($fieldName, self::TYPE_INT, $description);
    }

    public static function float(string $fieldName, ?string $description = null): self
    {
        return new self($fieldName, self::TYPE_FLOAT, $description);
    }

    public static function double(string $fieldName, ?string $description = null): self
    {
        return new self($fieldName, self::TYPE_DOUBLE, $description);
    }

    public static function array(string $fieldName, ?string $description = null): self
    {
        return new self($fieldName, self::TYPE_ARRAY, $description);
    }

    public static function json(string $fieldName, ?string $description = null): self
    {
        return new self($fieldName, self::TYPE_JSON, $description);
    }
}
