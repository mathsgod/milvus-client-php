<?php

namespace Milvus;

class ResourceGroup
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(string $name, array $config)
    {
        return $this->client->post("/v2/vectordb/resource_groups/create", [
            "json" => [
                "name" => $name,
                "config" => $config
            ]
        ]);
    }

    public function describe(string $name)
    {
        return $this->client->post("/v2/vectordb/resource_groups/describe", [
            "json" => [
                "name" => $name
            ]
        ]);
    }

    public function drop(string $name)
    {
        return $this->client->post("/v2/vectordb/resource_groups/drop", [
            "json" => [
                "name" => $name
            ]
        ]);
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/resource_groups/list", [
            "body" => "{}"
        ]);
    }

    public function transferReplica(string $sourceRgName, string $targetRgName, string $collectionName, int $replicaNum)
    {
        return $this->client->post("/v2/vectordb/resource_groups/transfer_replica", [
            "json" => [
                "sourceRgName" => $sourceRgName,
                "targetRgName" => $targetRgName,
                "collectionName" => $collectionName,
                "replicaNum" => $replicaNum
            ]
        ]);
    }

    public function alter(array $resource_groups)
    {
        return $this->client->post("/v2/vectordb/resource_groups/alter", [
            "json" => [
                "resource_groups" => $resource_groups
            ]
        ]);
    }
}
