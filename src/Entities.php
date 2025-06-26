<?php

namespace Milvus;

use Exception;

class Entities
{
    private $client;
    private $collectionName;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function advancedSearch(string $collection_name, array $search, array $rerank, int $limit)
    {

        return $this->client->post('/v2/vectordb/entities/advanced_search', [
            'json' => [
                'collectionName' => $collection_name,
                'search' => $search,
                'rerank' => $rerank,
                'limit' => $limit
            ]
        ]);
    }

    public function insert(string $collection_name, array $data)
    {
        return  $this->client->post('/v2/vectordb/entities/insert', [
            'json' => [
                'collectionName' => $collection_name,
                'data' => $data
            ]
        ]);
    }

    public function search(string $collection_name, string $annsField, array $data, ?int $limit)
    {
        return  $this->client->post('/v2/vectordb/entities/search', [
            'json' => [
                'collectionName' => $collection_name,
                'data' => $data,
                'annsField' => $annsField,
                "limit" => $limit
            ]
        ]);
    }

    public function query(string $filter)
    {
        return  $this->client->post('/v2/vectordb/entities/query', [
            'json' => [
                'collectionName' => $this->collectionName,
                'filter' => $filter
            ]
        ]);
    }

    public function get(array $ids)
    {
        return  $this->client->post('/v2/vectordb/entities/get', [
            'json' => [
                'collectionName' => $this->collectionName,
                'id' => $ids
            ]
        ]);
    }

    public function delete(string $collection_name, ?string $filter = null, ?array $ids = null, ?string $partition_name = null)
    {
        if ($filter === null && $ids === null) {
            throw new Exception("Either filter or ids must be provided for deletion.");
        }

        if ($ids !== null) {
            $filter = "id in [" . implode(',', $ids) . "]";
        }

        return $this->client->post('/v2/vectordb/entities/delete', [
            'json' => [
                'collectionName' => $collection_name,
                'filter' => $filter,
                'partitionName' => $partition_name
            ]
        ]);
    }

    public function upsert(string $collection_name, array $data)
    {
        return  $this->client->post('/v2/vectordb/entities/upsert', [
            'json' => [
                'collectionName' => $collection_name,
                'data' => $data
            ]
        ]);
    }
}
