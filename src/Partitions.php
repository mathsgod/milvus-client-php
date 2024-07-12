<?php

namespace Milvus;

class Partitions
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/partitions/list", [
            "body" => json_encode([
                "collectionName" => $collectionName,
            ]),
        ]);
    }
}
