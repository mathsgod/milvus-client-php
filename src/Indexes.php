<?php

namespace Milvus;

class Indexes
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $params)
    {
        return $this->client->post("/v2/vectordb/indexes/create", [
            "json" => $params
        ]);
    }

    public function describe(array $params)
    {
        return $this->client->post("/v2/vectordb/indexes/describe", [
            "json" => $params
        ]);
    }

    public function dropProperties(array $params)
    {
        return $this->client->post("/v2/vectordb/indexes/drop_properties", [
            "json" => $params
        ]);
    }

    public function drop(array $params)
    {
        return $this->client->post("/v2/vectordb/indexes/drop", [
            "json" => $params
        ]);
    }

    public function list(array $params)
    {
        return $this->client->post("/v2/vectordb/indexes/list", [
            "json" => $params
        ]);
    }
}
