<?php

namespace Milvus;

class Roles
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/roles/list", [
            "body" => "{}",
        ]);
    }

    public function create(string $roleName)
    {
        return $this->client->post("/v2/vectordb/roles/create", [
            "body" => json_encode([
                "roleName" => $roleName,
            ]),
        ]);
    }

    public function describe(string $role_name)
    {
        return $this->client->post("/v2/vectordb/roles/describe", [
            "body" => json_encode([
                "roleName" => $role_name,
            ]),
        ]);
    }

    public function drop(string $role_name)
    {
        return $this->client->post("/v2/vectordb/roles/drop", [
            "body" => json_encode([
                "roleName" => $role_name,
            ]),
        ]);
    }

    public function grantPrivilege(string $role_name, string $object_type, string $object_name, string $privilege)
    {
        return $this->client->post("/v2/vectordb/roles/grant_privilege", [
            "body" => json_encode([
                "roleName" => $role_name,
                "objectType" => $object_type,
                "objectName" => $object_name,
                "privilege" => $privilege,
            ]),
        ]);
    }

    public function revokePrivilege(string $role_name, string $object_type, string $object_name, string $privilege)
    {
        return $this->client->post("/v2/vectordb/roles/revoke_privilege", [
            "body" => json_encode([
                "roleName" => $role_name,
                "objectType" => $object_type,
                "objectName" => $object_name,
                "privilege" => $privilege,
            ]),
        ]);
    }
}
