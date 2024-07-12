<?php

namespace Milvus;

class Roles
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/roles/list", [
            "body" => "{}",
        ]);
    }
}
