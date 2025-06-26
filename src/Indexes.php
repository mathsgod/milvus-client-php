<?php

namespace Milvus;

class Indexes
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(
        string $collection_name,
        IndexParams $index_params,
    ) {
        return $this->client->post("/v2/vectordb/indexes/create", [
            "body" => json_encode([
                "collectionName" => $collection_name,
                "indexParams" => $index_params,
            ]),
        ]);
    }

    public function describe(string $collection_name, string $index_name)
    {
        return $this->client->post("/v2/vectordb/indexes/describe", [
            "body" => json_encode([
                "collectionName" => $collection_name,
                "indexName" => $index_name,
            ]),
        ]);
    }

    public function dropProperties(string $collection_name, string $index_name, array $property_keys)
    {
        return $this->client->post("/v2/vectordb/indexes/drop_properties", [
            "body" => json_encode([
                "collectionName" => $collection_name,
                "indexName" => $index_name,
                "propertyKeys" => $property_keys,
            ]),
        ]);
    }

    public function drop(string $collection_name, string $index_name)
    {
        return $this->client->post("/v2/vectordb/indexes/drop", [
            "body" => json_encode([
                "collectionName" => $collection_name,
                "indexName" => $index_name,
            ]),
        ]);
    }

    public function list(string $collection_name)
    {
        return $this->client->post("/v2/vectordb/indexes/list", [
            "body" => json_encode([
                "collectionName" => $collection_name,
            ]),
        ]);
    }
}
