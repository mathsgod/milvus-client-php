<?php

namespace Milvus\Http;

use Milvus\Client;

class ResourceGroups
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $params)
    {
        return $this->client->post("/v2/vectordb/resource_groups/create", [
            "json" => $params
        ]);
    }

    public function describe(array $params)
    {
        return $this->client->post("/v2/vectordb/resource_groups/describe", [
            "json" => $params
        ]);
    }

    public function drop(array $params)
    {
        return $this->client->post("/v2/vectordb/resource_groups/drop", [
            "json" => $params
        ]);
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/resource_groups/list", [
            "body" => "{}"
        ]);
    }

    public function transferReplica(array $params)
    {
        return $this->client->post("/v2/vectordb/resource_groups/transfer_replica", [
            "json" => $params
        ]);
    }

    public function alter(array $params)
    {
        return $this->client->post("/v2/vectordb/resource_groups/alter", [
            "json" => $params
        ]);
    }
}