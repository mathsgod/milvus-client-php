<?php

namespace Milvus;

class Partitions
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $params)
    {
        return $this->client->post("/v2/vectordb/partitions/create", [
            "json" => $params
        ]);
    }

    public function drop(array $params)
    {
        return $this->client->post("/v2/vectordb/partitions/drop", [
            "json" => $params
        ]);
    }

    public function getStats(array $params)
    {
        return $this->client->post("/v2/vectordb/partitions/get_stats", [
            "json" => $params
        ]);
    }

    public function has(array $params)
    {
        return $this->client->post("/v2/vectordb/partitions/has", [
            "json" => $params
        ]);
    }

    public function list(array $params)
    {
        return $this->client->post("/v2/vectordb/partitions/list", [
            "json" => $params
        ]);
    }

    public function load(array $params)
    {
        return $this->client->post("/v2/vectordb/partitions/load", [
            "json" => $params
        ]);
    }

    public function release(array $params)
    {
        return $this->client->post("/v2/vectordb/partitions/release", [
            "json" => $params
        ]);
    }
}
