<?php

namespace Milvus;

class Partition
{
    private $client;
    private $collection;
    private $name;

    public function __construct(Client $client, Collection $collection, string $name)
    {
        $this->client = $client;
        $this->collection = $collection;
        $this->name = $name;
    }
}
