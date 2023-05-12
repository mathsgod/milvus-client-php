<?php

namespace Milvus;

class Field
{
    private $client;
    public $name;
    public $description;
    public $data_type;
    public $is_primary_key;


    public function __construct(Client $client, string $name)
    {
        $this->client = $client;
        $this->name = $name;
    }


    public function __debugInfo()
    {
        return [
            "name" => $this->name,
            "is_primary_key" => $this->is_primary_key,
            "data_type" => $this->data_type,
            "type_params" => $this->type_params
        ];
    }
}
