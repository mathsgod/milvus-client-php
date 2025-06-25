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


    public function has(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/has", [
            "json" => [
                "collectionName" => $collectionName,
                "dbName" => $this->dbName
            ],
        ]);
    }


    public function getStats(string $collectionName)
    {
        return $this->client->post('/v2/vectordb/collections/get_stats', [
            'json' => [
                'collectionName' => $collectionName,
                'dbName' => $this->dbName
            ]
        ]);
    }

    public function load(string $collection_name)
    {
        return $this->client->post("/v2/vectordb/collections/load", [
            "json" => [
                "collection_name" => $collection_name
            ],
        ]);
    }

    public function getLoadState(string $collection_name)
    {
        return $this->client->post("/v2/vectordb/collections/getLoadState", [
            "json" => [
                "collection_name" => $collection_name
            ],
        ]);
    }

    public function drop(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/drop", [
            "json" => [
                "collectionName" => $collectionName,
                "dbName" => $this->dbName
            ],
        ]);
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/collections/list", [
            "json" => [
                "dbName" => $this->dbName
            ],
        ]);
    }

    public function rename(string $old_name, string $new_name)
    {
        return $this->client->post("/v2/vectordb/collections/rename", [
            "json" => [
                "collectionName" => $old_name,
                "newCollectionName" => $new_name
            ],
        ]);
    }

    public function release(string $collectionName)
    {
        return $this->client->post('/v2/vectordb/collections/release', [
            'json' => [
                'collectionName' => $collectionName,
                'dbName' => $this->dbName
            ]
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

    public function delete(string $collection_name, ?string $filter = null, ?array $ids = null, ?string $partition_name = null)
    {
        return (new Entities($this->client, $collection_name))->delete($filter, $ids, $partition_name);
    }

    public function create(
        string $collection_name,
        int $dimension,
        string $primary_field_name = "id",
        string $vector_field_name = "vector",
        string $metric_type = "CONSINE",
        bool $auto_id = false,
        ?float $timeout = null,
        ?CollectionSchema $schema = null,
        ?IndexParams $index_params = null
    ) {

        return $this->client->post("/v2/vectordb/collections/create", [
            "json" => [
                "collectionName" => $collection_name,
                "schema" => $schema->toArray(),
                "indexParams" => $index_params
            ],
        ]);
    }
}
