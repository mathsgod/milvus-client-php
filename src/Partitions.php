<?php

namespace Milvus;

class Partitions
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(string $collectionName, string $partitionName)
    {
        return $this->client->post("/v2/vectordb/partitions/create", [
            "body" => json_encode([
                "collectionName" => $collectionName,
                "partitionName" => $partitionName,
            ]),
        ]);
    }

    public function drop(string $collectionName, string $partitionName)
    {
        return $this->client->post("/v2/vectordb/partitions/drop", [
            "body" => json_encode([
                "collectionName" => $collectionName,
                "partitionName" => $partitionName,
            ]),
        ]);
    }

    public function getStats(string $collectionName, string $partitionName)
    {
        return $this->client->post("/v2/vectordb/partitions/get_stats", [
            "body" => json_encode([
                "collectionName" => $collectionName,
                "partitionName" => $partitionName,
            ]),
        ]);
    }

    public function has(string $collectionName, string $partitionName)
    {
        return $this->client->post("/v2/vectordb/partitions/has", [
            "body" => json_encode([
                "collectionName" => $collectionName,
                "partitionName" => $partitionName,
            ]),
        ]);
    }

    public function list(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/partitions/list", [
            "body" => json_encode([
                "collectionName" => $collectionName,
            ]),
        ]);
    }

    public function load(string $collectionName, array $partitionNames)
    {
        return $this->client->post("/v2/vectordb/partitions/load", [
            "body" => json_encode([
                "collectionName" => $collectionName,
                "partitionNames" => $partitionNames,
            ]),
        ]);
    }

    public function release(string $collectionName, array $partitionNames)
    {
        return $this->client->post("/v2/vectordb/partitions/release", [
            "body" => json_encode([
                "collectionName" => $collectionName,
                "partitionNames" => $partitionNames,
            ]),
        ]);
    }
}
