<?php

namespace Milvus;

class Client
{
    private $client;
    public function __construct(string $server = "localhost", int $port = 19530)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => "http://$server:$port",
            "verify" => false,
            "headers" => [
                "Content-Type" => "application/json",
            ]
        ]);
    }

    public function aliases()
    {
        return new Aliases($this);
    }

    public function entities(string $collectionName)
    {
        return new Entities($this, $collectionName);
    }

    public function collection(string $name)
    {
        return new Collection($this, $name);
    }

    public function collections()
    {
        return new Collections($this);
    }

    public function roles()
    {
        return new Roles($this);
    }

    public function users()
    {
        return new Users($this);
    }

    public function post($uri, array $options = []): array
    {
        $response = $this->client->post($uri, $options);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data["code"] !== 0)
            throw new \Exception($data["message"], $data["code"]);

        return $data["data"];
    }
}
