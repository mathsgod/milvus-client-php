<?php

namespace Milvus;

class Schema
{
    public $name;
    public $description;
    public $fields = [];

    public $autoID;

    public static function FromArray(array $array)
    {
        $schema = new Schema();
        $schema->name = $array["name"];
        $schema->description = $array["description"];
        foreach ($array["fields"] as $field) {
            $schema->fields[] = Field::FromArray($field);
        }
        return $schema;
    }

    public function addField(Field|array $field)
    {
        $this->fields[] = $field;
    }

    public function toArray()
    {
        $array = [
            "name" => $this->name,
            "description" => $this->description,
            "fields" => [],
        ];
        foreach ($this->fields as $field) {
            $array["fields"][] = is_array($field) ? $field : $field->toArray();
        }
        return $array;
    }
}
