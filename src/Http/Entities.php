<?php

namespace Milvus\Http;

use Exception;
use JsonSerializable;
use Milvus\Client;

class Entities
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * This operation deletes entities by their IDs or with a boolean expression.
     * @param array $params
     */
    public function delete(array $params)
    {
        return $this->client->post('/v2/vectordb/entities/delete', [
            'json' => $params
        ]);
    }

    /**
     * This operation gets specific entities by their IDs.
     * @param array $params
     */
    public function get(array $params)
    {
        return $this->client->post('/v2/vectordb/entities/get', [
            'json' => $params
        ]);
    }

    /**
     * This operation searches for entities based on vector similarity and scalar filtering and reranks the results using a specified strategy.
     * @param array $params
     */
    public function hybridSearch(array $params)
    {
        return $this->client->post('/v2/vectordb/entities/hybrid_search', [
            'json' => $params
        ]);
    }

    /**
     * This operation inserts data into a specific collection.
     * @param array $params
     */
    public function insert(array $params)
    {
        return $this->client->post('/v2/vectordb/entities/insert', [
            'json' => $params
        ]);
    }

    /**
     * This operation conducts a filtering on the scalar field with a specified boolean expression.
     * @param array $params
     */
    public function query(array $params)
    {
        return $this->client->post('/v2/vectordb/entities/query', [
            'json' => $params
        ]);
    }

    /**
     * This operation conducts a vector similarity search with an optional scalar filtering expression.
     * @param array $params
     */
    public function search(array $params)
    {
        return $this->client->post('/v2/vectordb/entities/search', [
            'json' => $params
        ]);
    }

    /**
     * This operation inserts new records into the database or updates existing ones.
     * @param array $params
     */
    public function upsert(array $params)
    {
        return $this->client->post('/v2/vectordb/entities/upsert', [
            'json' => $params
        ]);
    }

    /**
     * @param array $params
     */
    public function advancedSearch(array $params)
    {
        return $this->client->post('/v2/vectordb/entities/advanced_search', [
            'json' => $params
        ]);
    }
}