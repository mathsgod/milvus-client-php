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
        string|array|null $partition_name = null,
        ?string $consistency_level = null,
        ?int $offset = null,
        ?int $group_size = null,
        ?bool $strict_group_size = null,
        ?array $expr_params = null,
        ?array $function_score = null
    ) {
        if (is_string($partition_name)) {
            $partition_name = [$partition_name];
        }

        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'search' => $search,
            'rerank' => $ranker,
            'limit' => $limit,
            'offset' => $offset,
            'groupSize' => $group_size,
            'strictGroupSize' => $strict_group_size,
            'outputFields' => $output_fields,
            'partitionNames' => $partition_name,
            'consistencyLevel' => $consistency_level,
            'exprParams' => $expr_params,
            'functionScore' => $function_score,
        ];

        return (new Entities($this))->hybridSearch(
            array_filter($params, fn ($value) => $value !== null)
        );
    }

    /**
     * This operation inserts data into a specific collection.
     */
    public function insert(
        string $collection_name,
        array $data,
        ?string $partition_name = null,
        ?bool $partial_update = null
    ) {
        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'data' => $data,
            'partitionName' => $partition_name,
            'partialUpdate' => $partial_update,
        ];

        return (new Entities($this))->insert(
            array_filter($params, fn ($value) => $value !== null)
        );
    }

    /**
     * This operation gets specific entities by their IDs.
     */
    public function get(
        string $collection_name,
        array $ids,
        ?array $output_fields = null,
        ?array $partition_names = null,
        ?string $consistency_level = null,
        string|int|null $partition_name = null
    ) {
        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'id' => $ids,
            'outputFields' => $output_fields,
            'partitionNames' => $partition_names,
            'consistencyLevel' => $consistency_level,
            'partitionName' => $partition_name,
        ];

        return (new Entities($this))->get(
            array_filter($params, fn ($value) => $value !== null)
        );
    }

    /**
     * This operation deletes entities by their IDs or with a boolean expression.
     */
    public function delete(
        string $collection_name,
        ?string $filter = null,
        ?array $ids = null,
        ?string $partition_name = null,
        string|int|null $id = null,
        ?array $expr_params = null
    ) {
        if ($ids !== null) {
            $filter = 'id in [' . implode(',', array_map(
                static function ($entity_id): string {
                    if (is_int($entity_id) || is_float($entity_id)) {
                        return (string) $entity_id;
                    }

                    if (is_string($entity_id)) {
                        return json_encode($entity_id, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
                    }

                    throw new \InvalidArgumentException('Entity IDs must be integers, floats, or strings.');
                },
                $ids
            )) . ']';
        }

        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'filter' => $filter,
            'partitionName' => $partition_name,
            'id' => $id,
            'exprParams' => $expr_params,
        ];

        return (new Entities($this))->delete(
            array_filter($params, fn ($value) => $value !== null)
        );
    }

    /**
     * This operation conducts a scalar filtering with a specified boolean expression.
     */
    public function query(
        string $collection_name,
        ?string $filter = null,
        ?array $output_fields = null,
        ?array $partition_names = null,
        ?int $limit = null,
        ?int $offset = null,
        ?array $expr_params = null,
        ?string $consistency_level = null
    ) {
        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'filter' => $filter,
            'outputFields' => $output_fields,
            'partitionNames' => $partition_names,
            'limit' => $limit,
            'offset' => $offset,
            'exprParams' => $expr_params,
            'consistencyLevel' => $consistency_level,
        ];

        return (new Entities($this))->query(
            array_filter($params, fn ($value) => $value !== null)
        );
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
        ?int $offset = null,
        ?string $grouping_field = null,
        ?int $group_size = null,
        ?bool $strict_group_size = null,
        ?array $expr_params = null,
        ?array $function_score = null,
        ?array $ids = null
    ) {
        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'data' => $data,
            'ids' => $ids,
            'filter' => $filter,
            'outputFields' => $output_fields,
            'annsField' => $anns_field,
            'limit' => $limit,
            'offset' => $offset,
            'groupingField' => $grouping_field,
            'groupSize' => $group_size,
            'strictGroupSize' => $strict_group_size,
            'searchParams' => $search_params,
            'partitionNames' => $partition_names,
            'consistencyLevel' => $consistency_level,
            'exprParams' => $expr_params,
            'functionScore' => $function_score,
        ];

        if ($ids !== null && $data === []) {
            unset($params['data']);
        }

        return (new Entities($this))->search(
            array_filter($params, fn ($value) => $value !== null)
        );
    }

    public function upsert(
        string $collection_name,
        array $data,
        ?string $partition_name = null,
        ?bool $partial_update = null
    ) {
        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'data' => $data,
            'partitionName' => $partition_name,
            'partialUpdate' => $partial_update,
        ];

        return (new Entities($this))->upsert(
            array_filter($params, fn ($value) => $value !== null)
        );
    }
}
