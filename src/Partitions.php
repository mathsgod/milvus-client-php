<?php

namespace Milvus;

class Partitions
{
    private $client;
    private $collectionName;

    public function __construct(Client $client, string $collectionName)
    {
        $this->client = $client;
        $this->collectionName = $collectionName;
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/partitions/list", [
            "body" => json_encode([
                "collectionName" => $this->collectionName,
            ]),
        ]);
    }
}
