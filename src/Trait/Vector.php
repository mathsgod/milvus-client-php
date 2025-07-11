<?php

namespace Milvus\Trait;


use Milvus\Http\Entities;

trait Vector
{
    /**
     * This operation performs multi-vector search on a collection and returns search results after reranking.
     */
    public function hybridSearch(
        string $collection_name,
        array $search,
        $ranker,
        ?int $limit = null,
        ?array $output_fields = null,
        ?string $partition_name = null,
        ?string $consistency_level = null
    ) {
        return (new Entities($this))->hybridSearch([
            'collectionName' => $collection_name,
            'search' => $search,
            'rerank' => $ranker,
            'limit' => $limit,
            'outputFields' => $output_fields,
            'partitionNames' => $partition_name,
            'consistencyLevel' => $consistency_level
        ]);
    }

    /**
     * This operation inserts data into a specific collection.
     */
    public function insert(
        string $collection_name,
        array $data,
    ) {
        return (new Entities($this))->insert([
            'collectionName' => $collection_name,
            'data' => $data
        ]);
    }

    /**
     * This operation gets specific entities by their IDs.
     */
    public function get(string $collection_name, array $ids, ?array $output_fields = null)
    {
        return (new Entities($this))->get([
            'collectionName' => $collection_name,
            'id' => $ids,
            'outputFields' => $output_fields
        ]);
    }

    /**
     * This operation deletes entities by their IDs or with a boolean expression.
     */
    public function delete(
        string $collection_name,
        ?string $filter = null,
        ?array $ids = null
    ) {

        if ($ids !== null) {
            $filter = "id in [" . implode(',', $ids) . "]";
        }

        return (new Entities($this))->delete([
            'collectionName' => $collection_name,
            'filter' => $filter
        ]);
    }

    /**
     * This operation conducts a scalar filtering with a specified boolean expression.
     */
    public function query(
        string $collection_name,
        string $filter,
        ?array $output_fields = null,
        ?array $partition_names = null,
        ?int $limit = null,
        ?int $offset = null
    ) {
        return (new Entities($this))
            ->query([
                'collectionName' => $collection_name,
                'filter' => $filter,
                'outputFields' => $output_fields,
                'partitionNames' => $partition_names,
                'limit' => $limit,
                'offset' => $offset
            ]);
    }

    public function search(
        string $collection_name,
        array $data,
        string $filter = "",
        int $limit = 10,
        ?array $output_fields = null,
        ?array $search_params = null,
        ?string $anns_field = "vector",
        ?array $partition_names = null,
        ?string $consistency_level = null,

    ) {
        return (new Entities($this))->search([
            'collectionName' => $collection_name,
            'data' => $data,
            'filter' => $filter,
            'outputFields' => $output_fields,
            'annsField' => $anns_field,
            'limit' => $limit,
            'searchParams' => $search_params,
            'partitionNames' => $partition_names,
            'consistencyLevel' => $consistency_level
        ]);
    }

    public function upsert(
        string $collection_name,
        array $data,
        ?string $partition_name = null
    ) {
        return (new Entities($this))->upsert([
            'collectionName' => $collection_name,
            'data' => $data,
            'partitionName' => $partition_name
        ]);
    }
}
