<?php

namespace Milvus\Trait;

use Milvus\Entities;

trait Vector
{
    /**
     * This operation performs multi-vector search on a collection and returns search results after reranking.
     */
    public function hybrid_search(
        string $collection_name,
        array $reqs,
        ?array $ranker = null,
        ?int $limit = null,
        ?array $outputFields = []
    ) {
        return (new Entities($this))->hybridSearch(
            $collection_name,
            $reqs,
            $ranker,
            $limit,
            $outputFields
        );
    }

    /**
     * This operation inserts data into a specific collection.
     */
    public function insert(
        string $collection_name,
        array $data,
    ) {
        return $this->entities()->insert($collection_name, $data);
    }

    /**
     * This operation gets specific entities by their IDs.
     */
    public function get(string $collection_name, array $ids, ?array $output_fields = null)
    {
        return (new Entities($this))->get($collection_name, $ids, $output_fields);
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

        return (new Entities($this))->delete($collection_name, $filter);
    }

    /**
     * This operation conducts a scalar filtering with a specified boolean expression.
     */
    public function query(
        string $collection_name,
        string $filter,
        ?array $output_fields = null
    ) {
        return (new Entities($this))
            ->query(
                collectionName: $collection_name,
                filter: $filter,
                outputFields: $output_fields
            );
    }

    public function search(
        string $collection_name,
        array $data,
        string $filter = "",
        int $limit = 10,
        ?array $output_fields = null,
        ?array $search_params = null,
        ?string $anns_field = null,
        ?array $partition_names = null,

    ) {
        return (new Entities($this))->search(
            collectionName: $collection_name,
            data: $data,
            annsField: $anns_field,
            limit: $limit,
            searchParams: $search_params,
            partitionNames: $partition_names,
        );
    }

    public function upsert(
        string $collection_name,
        array $data,
        ?string $partition_name = null
    ) {
        return (new Entities($this))->upsert($collection_name, $data, $partition_name);
    }
}
