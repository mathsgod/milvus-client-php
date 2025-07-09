<?php

namespace Milvus\Http;

use Milvus\Client;

class Aliases
{
    private $client;
    public $dbName = "default";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * This operation reassigns the alias of one collection to another.
     */
    public function alter(array $params)
    {
        return $this->client->post("/v2/vectordb/aliases/alter", [
            "json" => $params
        ]);
    }

    public function create(array $params)
    {
        return $this->client->post("/v2/vectordb/aliases/create", [
            "json" => $params
        ]);
    }

    public function describe(array $params)
    {
        return $this->client->post("/v2/vectordb/aliases/describe", [
            "json" => $params
        ]);
    }

    public function drop(array $params)
    {
        return $this->client->post("/v2/vectordb/aliases/drop", [
            "json" => $params
        ]);
    }

    public function list(array $params = [])
    {
        return $this->client->post("/v2/vectordb/aliases/list", [
            "json" => $params
        ]);
    }
}