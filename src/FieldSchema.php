<?php

namespace Milvus;

class FieldSchema implements \JsonSerializable
{

    public function __construct(
        protected string $name,
        protected string $dtype,
        protected ?string $description = null,
        protected ?bool $is_primary = null,
        protected ?bool $auto_id = null,
        protected ?bool $is_partition_key = null,
        protected ?int $max_length  = null,
        protected ?int $dim  = null,
    ) {}

    public function jsonSerialize(): mixed
    {
        $field = [
            'fieldName' => $this->name,
            'dataType' => $this->dtype,
        ];

        if ($this->description !== null) {
            $field['description'] = $this->description;
        }
        if ($this->is_primary !== null) {
            $field['isPrimary'] = $this->is_primary;
        }
        if ($this->auto_id !== null) {
            $field['autoID'] = $this->auto_id;
        }
        if ($this->is_partition_key !== null) {
            $field['isPartitionKey'] = $this->is_partition_key;
        }
        if ($this->max_length !== null) {
            $field["elementTypeParams"] = [
                "max_length" => $this->max_length
            ];
        }
        if ($this->dim !== null) {
            $field["elementTypeParams"] = [
                "dim" => $this->dim
            ];
        }

        return $field;
    }
}
