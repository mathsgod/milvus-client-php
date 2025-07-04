<?php

namespace Milvus;

use Exception;

class Databases
{
    private $client;
    public $dbName = "default";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function alter(string $dbName, array $properties = [])
    {
        return $this->client->post("/v2/vectordb/databases/alter", [
            "json" => [
                "dbName" => $dbName,
                "properties" => $properties,
            ],
        ]);
    }

    public function create(string $dbName, ?array $properties = null)
    {
        return $this->client->post("/v2/vectordb/databases/create", [
            "json" => [
                "dbName" => $dbName,
                "properties" => $properties,
            ],
        ]);
    }

    public function describe(string $dbName)
    {
        return $this->client->post("/v2/vectordb/databases/describe", [
            "json" => [
                "dbName" => $dbName,
            ],
        ]);
    }

    public function drop(string $dbName)
    {
        return $this->client->post("/v2/vectordb/databases/drop", [
            "json" => [
                "dbName" => $dbName,
            ],
        ]);
    }

    public function dropProperties(string $dbName, array $propertyKeys)
    {
        return $this->client->post("/v2/vectordb/databases/drop_properties", [
            "json" => [
                "dbName" => $dbName,
                "propertyKeys" => $propertyKeys,
            ],
        ]);
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/databases/list", [
            "body" => "{}"
        ]);
    }
}
