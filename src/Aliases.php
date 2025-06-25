<?php

namespace Milvus;

class Aliases
{
    private $client;
    public $dbName = "default";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/aliases/list", [
            "body" => "{}"
        ]);
    }

    public function create(string $collection_name, string $alias)
    {
        return $this->client->post("/v2/vectordb/aliases/create", [
            "json" => [
                "aliasName" => $alias,
                "collectionName" => $collection_name,
            ],
        ]);
    }


    /**
     * This operation reassigns the alias of one collection to another.
     */
    public function alter(string $collection_name, string $alias)
    {
        return $this->client->post("/v2/vectordb/aliases/alter", [
            "json" => [
                "aliasName" => $alias,
                "collectionName" => $collection_name,
            ],
        ]);
    }

    public function describe(string $alias)
    {
        return $this->client->post("/v2/vectordb/aliases/describe", [
            "json" => [
                "aliasName" => $alias,
            ],
        ]);
    }

    public function drop(string $alias)
    {
        return $this->client->post("/v2/vectordb/aliases/drop", [
            "json" => [
                "aliasName" => $alias,
            ],
        ]);
    }
}
