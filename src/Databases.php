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

    public function create(string $dbName, array $properties = [])
    {
        return $this->client->post("/v2/vectordb/databases/create", [
            "json" => [
                "dbName" => $dbName,
                "properties" => $properties,
            ],
        ]);
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

    public function drop(string $dbName)
    {
        return $this->client->post("/v2/vectordb/databases/drop", [
            "json" => [
                "dbName" => $dbName,
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
}
