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

    public function create(string $collectionName, int $dimesion, array $options = [])
    {
        return $this->client->post("/v2/vectordb/collections/create", [
            "json" => [
                "collectionName" => $collectionName,
                "dimension" => $dimesion,
            ],
        ]);
    }
}
