<?php

namespace Milvus;

use Exception;
use JsonSerializable;

class Entities
{
    private $client;

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

    /**
     * This operation gets specific entities by their IDs.
     * @param string $collectionName The name of the collection to which this operation applies.
     * @param string|integer|array<string>|array<int> $id A specific entity ID or a list of entity IDs.
     * @param array $outputFields An array of fields to return along with the query results.
     * @param string $partitionNames The name of the partitions to which this operation applies.
     */
    public function get(string $collectionName, $id, ?array $outputFields = null, ?string $partitionNames = null)
    {
        return  $this->client->post('/v2/vectordb/entities/get', [
            'json' => [
                'collectionName' => $collectionName,
                'id' => $id,
                'outputFields' => $outputFields,
                'partitionNames' => $partitionNames
            ]
        ]);
    }

    /**
     * This operation searches for entities based on vector similarity and scalar filtering and reranks the results using a specified strategy.
     */
    public function hybridSearch(
        string $collectionName,
        array $search,
        array|JsonSerializable $rerank,
        ?int $limit,
        ?array $outputFields = null,
        ?array $partitionNames = null,
        ?string $consistencyLevel = null
    ) {
        return $this->client->post('/v2/vectordb/entities/hybrid_search', [
            'json' => [
                'collectionName' => $collectionName,
                'search' => $search,
                'rerank' => $rerank,
                'limit' => $limit,
                'outputFields' => $outputFields,
                'partitionNames' => $partitionNames,
                'consistencyLevel' => $consistencyLevel
            ]
        ]);
    }


    /**
     * This operation inserts data into a specific collection.
     */
    public function insert(string $collection_name, array $data, ?string $partitionName = null)
    {
        return  $this->client->post('/v2/vectordb/entities/insert', [
            'json' => [
                'collectionName' => $collection_name,
                'data' => $data,
                'partitionName' => $partitionName
            ]
        ]);
    }


    /**
     * This operation conducts a filtering on the scalar field with a specified boolean expression.
     */
    public function query(
        string $collectionName,
        string $filter,
        ?int $limit = null,
        ?int $offset = null,
        ?array $outputFields = null,
        ?string $partitionNames = null
    ) {
        return  $this->client->post('/v2/vectordb/entities/query', [
            'json' => [
                'collectionName' => $collectionName,
                'filter' => $filter,
                'limit' => $limit,
                'offset' => $offset,
                'outputFields' => $outputFields,
                'partitionNames' => $partitionNames
            ]
        ]);
    }

    /**
     * This operation conducts a vector similarity search with an optional scalar filtering expression.
     */
    public function search(
        string $collectionName,
        array $data,
        string $annsField,
        ?string  $filter = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $groupingField = null,
        ?array $outputFields = null,
        ?array $searchParams = null,
        ?array $partitionNames = null,
        ?string $consistencyLevel = null
    ) {
        $json = [
            'collectionName' => $collectionName,
            'data' => $data,
            'annsField' => $annsField,
            "limit" => $limit,
            "filter" => $filter,
            "offset" => $offset,
            "groupingField" => $groupingField,
            "outputFields" => $outputFields,
            "searchParams" => $searchParams,
            "partitionNames" => $partitionNames,
            "consistencyLevel" => $consistencyLevel
        ];

        $json = array_filter($json, fn($v) => $v !== null);
        return  $this->client->post('/v2/vectordb/entities/search', [
            'json' => $json
        ]);
    }


    /**
     * This operation inserts new records into the database or updates existing ones.
     */
    public function upsert(string $collection_name, array $data, ?string $partitionName = null)
    {
        return  $this->client->post('/v2/vectordb/entities/upsert', [
            'json' => [
                'collectionName' => $collection_name,
                'data' => $data,
                'partitionName' => $partitionName
            ]
        ]);
    }

    public function advancedSearch(string $collectionName, array $search, array $rerank, int $limit)
    {

        return $this->client->post('/v2/vectordb/entities/advanced_search', [
            'json' => [
                'collectionName' => $collectionName,
                'search' => $search,
                'rerank' => $rerank,
                'limit' => $limit
            ]
        ]);
    }
}
