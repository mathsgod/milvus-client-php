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

    public function create(string $user_name, string $password)
    {
        return $this->client->post("/v2/vectordb/users/create", [
            "body" => json_encode([
                "userName" => $user_name,
                "password" => $password,
            ]),
        ]);
    }

    public function describe(string $user_name)
    {
        return $this->client->post("/v2/vectordb/users/describe", [
            "body" => json_encode([
                "userName" => $user_name,
            ]),
        ]);
    }

    public function drop(string $user_name)
    {
        return $this->client->post("/v2/vectordb/users/drop", [
            "body" => json_encode([
                "userName" => $user_name,
            ]),
        ]);
    }

    public function grantRole(string $user_name, string $role_name)
    {
        return $this->client->post("/v2/vectordb/users/grant_role", [
            "body" => json_encode([
                "userName" => $user_name,
                "roleName" => $role_name,
            ]),
        ]);
    }

    public function revokeRole(string $user_name, string $role_name)
    {
        return $this->client->post("/v2/vectordb/users/revoke_role", [
            "body" => json_encode([
                "userName" => $user_name,
                "roleName" => $role_name,
            ]),
        ]);
    }

    public function updatePassword(string $user_name, string $password, string $new_password)
    {
        return $this->client->post("/v2/vectordb/users/update_password", [
            "body" => json_encode([
                "userName" => $user_name,
                "password" => $password,
                "newPassword" => $new_password,
            ]),
        ]);
    }
}
