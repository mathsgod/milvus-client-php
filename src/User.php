<?php

namespace Milvus;

class User
{
    private $client;
    private $userName;
    public function __construct(Client $client, string $userName)
    {
        $this->client = $client;
        $this->userName = $userName;
    }

    public function describe()
    {
        return $this->client->post("/v2/vectordb/users/describe", [
            "body" => json_encode([
                "userName" => $this->userName,
            ]),
        ]);
    }

    public function drop()
    {
        return $this->client->post("/v2/vectordb/users/drop", [
            "body" => json_encode([
                "userName" => $this->userName,
            ]),
        ]);
    }

    public function grantRole(string $roleName)
    {
        return $this->client->post("/v2/vectordb/users/grant_role", [
            "body" => json_encode([
                "userName" => $this->userName,
                "roleName" => $roleName,
            ]),
        ]);
    }

    public function revokeRole(string $roleName)
    {
        return $this->client->post("/v2/vectordb/users/revoke_role", [
            "body" => json_encode([
                "userName" => $this->userName,
                "roleName" => $roleName,
            ]),
        ]);
    }

    public function updatePassword(string $password, string $newPassword)
    {
        return $this->client->post("/v2/vectordb/users/update_password", [
            "body" => json_encode([
                "userName" => $this->userName,
                "password" => $password,
                "newPassword" => $newPassword,
            ]),
        ]);
    }
}
