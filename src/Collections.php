<?php

namespace Milvus;

use Exception;

class Collections
{
    private $client;
    public $dbName = "default";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/collections/list", [
            "json" => [
                "dbName" => $this->dbName
            ],
        ]);
    }

    public function describe(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/describe", [
            "json" => [
                "collectionName" => $collectionName,
                "dbName" => $this->dbName
            ],
        ]);
    }

    public function create(string $collectionName, Schema $schema, array $index_params = [])
    {
        return $this->client->post("/v2/vectordb/collections/create", [
            "json" => [
                "collectionName" => $collectionName,
                "schema" => $schema->toArray(),
                "params" => $index_params,
                "dbName" => $this->dbName,
            ],
        ]);
    }
}
