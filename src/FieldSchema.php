<?php

namespace Milvus;

class FieldSchema
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
}
