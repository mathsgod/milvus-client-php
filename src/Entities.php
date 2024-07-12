<?php

namespace Milvus;

class Entities
{
    private $client;
    private $collectionName;

    public function __construct(Client $client, string $collectionName)
    {
        $this->client = $client;
        $this->collectionName = $collectionName;
    }


    public function insert(array $data)
    {
        return  $this->client->post('/v2/vectordb/entities/insert', [
            'json' => [
                'collectionName' => $this->collectionName,
                'data' => $data
            ]
        ]);
    }

    public function search(string $annsField, array $data, ?int $limit)
    {
        return  $this->client->post('/v2/vectordb/entities/search', [
            'json' => [
                'collectionName' => $this->collectionName,
                'data' => $data,
                'annsField' => $annsField,
                "limit" => $limit
            ]
        ]);
    }

    public function query(string $filter,)
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

    public function delete(string $filter)
    {
        return $this->client->post('/v2/vectordb/entities/delete', [
            'json' => [
                'collectionName' => $this->collectionName,
                'filter' => $filter
            ]
        ]);
    }

    public function upsert(array $data)
    {
        return  $this->client->post('/v2/vectordb/entities/upsert', [
            'json' => [
                'collectionName' => $this->collectionName,
                'data' => $data
            ]
        ]);
    }
}
