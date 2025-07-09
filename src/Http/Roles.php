<?php

namespace Milvus\Http;

use Milvus\Client;

class Roles
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $params)
    {
        return $this->client->post("/v2/vectordb/roles/create", [
            "json" => $params,
        ]);
    }

    public function describe(array $params)
    {
        return $this->client->post("/v2/vectordb/roles/describe", [
            "json" => $params,
        ]);
    }

    public function drop(array $params)
    {
        return $this->client->post("/v2/vectordb/roles/drop", [
            "json" => $params,
        ]);
    }

    public function list(array $params = [])
    {
        return $this->client->post("/v2/vectordb/roles/list", [
            "json" => $params,
        ]);
    }

    public function grantPrivilege(array $params)
    {
        return $this->client->post("/v2/vectordb/roles/grant_privilege", [
            "json" => $params,
        ]);
    }

    public function revokePrivilege(array $params)
    {
        return $this->client->post("/v2/vectordb/roles/revoke_privilege", [
            "json" => $params,
        ]);
    }
}