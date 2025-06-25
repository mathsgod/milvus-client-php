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

    public function list()
    {
        return $this->client->post("/v2/vectordb/databases/list", [
            "body" => "{}"
        ]);
    }

    public function create(string $db_name, array $properties = [])
    {
        return $this->client->post("/v2/vectordb/databases/create", [
            "json" => [
                "dbName" => $db_name,
                "properties" => $properties,
            ],
        ]);
    }

    public function alter(string $db_name, array $properties = [])
    {
        return $this->client->post("/v2/vectordb/databases/alter", [
            "json" => [
                "dbName" => $db_name,
                "properties" => $properties,
            ],
        ]);
    }

    public function drop(string $db_name)
    {
        return $this->client->post("/v2/vectordb/databases/drop", [
            "json" => [
                "dbName" => $db_name,
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
