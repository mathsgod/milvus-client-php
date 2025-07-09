<?php

namespace Milvus\Http;

use Exception;
use Milvus\Client;

class Databases
{
    private $client;
    public $dbName = "default";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function alter(array $params)
    {
        return $this->client->post("/v2/vectordb/databases/alter", [
            "json" => $params
        ]);
    }

    public function create(array $params)
    {
        return $this->client->post("/v2/vectordb/databases/create", [
            "json" => $params
        ]);
    }

    public function describe(array $params)
    {
        return $this->client->post("/v2/vectordb/databases/describe", [
            "json" => $params
        ]);
    }

    public function drop(array $params)
    {
        return $this->client->post("/v2/vectordb/databases/drop", [
            "json" => $params
        ]);
    }

    public function dropProperties(array $params)
    {
        return $this->client->post("/v2/vectordb/databases/drop_properties", [
            "json" => $params
        ]);
    }

    public function list(array $params = [])
    {
        return $this->client->post("/v2/vectordb/databases/list", [
            "json" => $params
        ]);
    }
}