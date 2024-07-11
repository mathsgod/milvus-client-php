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
        $response = $this->client->post('/v2/vectordb/entities/insert', [
            'json' => [
                'collectionName' => $this->collectionName,
                'data' => $data
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function search(string $annsField, array $data)
    {
        $response = $this->client->post('/v2/vectordb/entities/search', [
            'json' => [
                'collectionName' => $this->collectionName,
                'data' => $data,
                'annsField' => $annsField,
                "limit" => 10
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return $data["data"];
    }

    public function query(string $filter,)
    {
        $response = $this->client->post('/v2/vectordb/entities/query', [
            'json' => [
                'collectionName' => $this->collectionName,
                'filter' => $filter
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return $data["data"];
    }

    public function get(array $ids)
    {
        $response = $this->client->post('/v2/vectordb/entities/get', [
            'json' => [
                'collectionName' => $this->collectionName,
                'id' => $ids
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return $data["data"];
    }

    public function delete(string $filter)
    {
        $response = $this->client->post('/v2/vectordb/entities/delete', [
            'json' => [
                'collectionName' => $this->collectionName,
                'filter' => $filter
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return $data["data"];
    }

    public function upsert(array $data)
    {
        $response = $this->client->post('/v2/vectordb/entities/upsert', [
            'json' => [
                'collectionName' => $this->collectionName,
                'data' => $data
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return $data["data"];
    }
}
