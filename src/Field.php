<?php

namespace Milvus;

class Field
{

    public $name;
    public $description;
    public $data_type;
    public $is_primary_key;
    public $type_params;


    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function FromArray(array $array)
    {
        $field = new Field($array["name"]);
        $field->description = $array["description"] ?? null;
        $field->data_type = $array["data_type"];
        $field->is_primary_key = $array["is_primary_key"];
        $field->type_params = $array["type_params"] ?? null;

        return $field;
    }

    public function toArray()
    {
        return [
            "name" => $this->name,
            "description" => $this->description,
            "data_type" => $this->data_type,
            "is_primary_key" => $this->is_primary_key,
            "type_params" => $this->type_params
        ];
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
