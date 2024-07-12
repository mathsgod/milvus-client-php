<?php

namespace Milvus;

class Users
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/users/list", [
            "body" => "{}",
        ]);
    }

    public function create(string $userName, string $password)
    {
        return $this->client->post("/v2/vectordb/users/create", [
            "body" => json_encode([
                "user_name" => $userName,
                "password" => $password,
            ]),
        ]);
    }
}
