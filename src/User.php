<?php

namespace Milvus;

class User
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        $content = $this->client->post("/v2/vectordb/users/list", [
            "body" => "{}",
        ])->getBody()->getContents();
        return json_decode($content, true);
    }
}
