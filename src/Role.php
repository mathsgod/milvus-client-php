<?php

namespace Milvus;

class Role
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        $content = $this->client->post("/v2/vectordb/roles/list", [
            "body" => "{}",
        ])->getBody()->getContents();
        return json_decode($content, true);
    }
}
