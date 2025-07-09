<?php

namespace Milvus\Http;

use Exception;
use Milvus\Client;

class Collections
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function addField(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/fields/add", [
            "json" => $params
        ]);
    }

    public function alterFieldProperties(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/fields/alter_properties", [
            "json" => $params
        ]);
    }

    public function alterProperties(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/alter_properties", [
            "json" => $params
        ]);
    }

    public function compact(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/compact", [
            "json" => $params
        ]);
    }

    public function create(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/create", [
            "json" => $params
        ]);
    }

    public function describe(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/describe", [
            "json" => $params
        ]);
    }

    public function drop(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/drop", [
            "json" => $params
        ]);
    }

    public function dropProperties(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/drop_properties", [
            "json" => $params
        ]);
    }

    public function flush(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/flush", [
            "json" => $params
        ]);
    }

    public function getLoadState(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/getLoadState", [
            "json" => $params
        ]);
    }

    public function getStats(array $params)
    {
        return $this->client->post('/v2/vectordb/collections/get_stats', [
            'json' => $params
        ]);
    }

    public function has(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/has", [
            "json" => $params
        ]);
    }

    public function list(array $params = [])
    {
        return $this->client->post("/v2/vectordb/collections/list", [
            "json" => $params
        ]);
    }

    public function load(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/load", [
            "json" => $params
        ]);
    }

    public function release(array $params)
    {
        return $this->client->post('/v2/vectordb/collections/release', [
            'json' => $params
        ]);
    }

    public function rename(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/rename", [
            "json" => $params
        ]);
    }

    public function refreshLoad(array $params)
    {
        return $this->client->post("/v2/vectordb/collections/refresh_load", [
            "json" => $params
        ]);
    }
}