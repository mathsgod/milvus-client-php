<?php

namespace Milvus\Http;

use Milvus\Client;

class PrivilegeGroups
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $params)
    {
        return $this->client->post("/v2/vectordb/privilege_groups/create", [
            "json" => $params,
        ]);
    }

    public function drop(array $params)
    {
        return $this->client->post("/v2/vectordb/privilege_groups/drop", [
            "json" => $params,
        ]);
    }

    public function list(array $params = [])
    {
        return $this->client->post("/v2/vectordb/privilege_groups/list", [
            "json" => $params,
        ]);
    }

    public function addPrivileges(array $params)
    {
        return $this->client->post("/v2/vectordb/privilege_groups/add_privileges_to_group", [
            "json" => $params,
        ]);
    }

    public function removePrivileges(array $params)
    {
        return $this->client->post("/v2/vectordb/privilege_groups/remove_privileges_from_group", [
            "json" => $params,
        ]);
    }
}
