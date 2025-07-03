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

    /**
     * This operation deletes entities by their IDs or with a boolean expression.
     * @param string $collection_name The name of an existing collection.
     * @param string $filter A scalar filtering condition to filter matching entities. You can set this parameter to an empty string to skip scalar filtering. To build a scalar filtering condition, refer to Boolean Expression Rules.
     * @param string|null The name of a partition in the current collection. If specified, the data is to be deleted from the specified partition.
     */
    public function delete(string $collection_name, string $filter, ?string $partition_name = null)
    {

        return $this->client->post('/v2/vectordb/entities/delete', [
            'json' => [
                'collectionName' => $collection_name,
                'filter' => $filter,
                'partitionName' => $partition_name
            ]
        ]);
    }

    public function hybridSearch(string $collection_name, array $search, array $rerank, int $limit, array $outputFields = [])
    {
        return $this->client->post('/v2/vectordb/entities/hybrid_search', [
            'json' => [
                'collectionName' => $collection_name,
                'search' => $search,
                'rerank' => $rerank,
                'limit' => $limit,
                'outputFields' => $outputFields
            ]
        ]);
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
