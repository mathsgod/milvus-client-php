<?php

namespace Milvus;

class Role
{
    private $client;
    private $roleName;

    public function __construct(Client $client, string $roleName)
    {
        $this->client = $client;
        $this->roleName = $roleName;
    }

    public function describe()
    {
        return $this->client->post("/v2/vectordb/roles/describe", [
            "body" => json_encode([
                "roleName" => $this->roleName,
            ]),
        ]);
    }

    public function drop()
    {
        return $this->client->post("/v2/vectordb/roles/drop", [
            "body" => json_encode([
                "roleName" => $this->roleName,
            ]),
        ]);
    }

    public function grantPrivilege(string $objectType, string $objectName, string $privilege)
    {
        return $this->client->post("/v2/vectordb/roles/grant_privilege", [
            "body" => json_encode([
                "roleName" => $this->roleName,
                "objectType" => $objectType,
                "objectName" => $objectName,
                "privilege" => $privilege,
            ]),
        ]);
    }
}
