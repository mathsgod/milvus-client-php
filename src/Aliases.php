<?php

namespace Milvus;

class Aliases
{
    private $client;
    public $dbName = "default";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/aliases/list", [
            "json" => [
                "dbName" => $this->dbName
            ],
        ]);
    }
}
