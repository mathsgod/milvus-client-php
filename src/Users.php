<?php

namespace Milvus;

class Users
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * This operation creates a new user with a corresponding password.
     */
    public function create(string $userName, string $password)
    {
        return $this->client->post("/v2/vectordb/users/create", [
            "json" => [
                "userName" => $userName,
                "password" => $password,
            ],
        ]);
    }

    /**
     * This operation describes the detailed information of a specific user.
     */
    public function describe(string $userName)
    {
        return $this->client->post("/v2/vectordb/users/describe", [
            "json" => [
                "userName" => $userName,
            ],
        ]);
    }

    /**
     * This operation deletes an existing user.
     */
    public function drop(string $userName)
    {
        return $this->client->post("/v2/vectordb/users/drop", [
            "json" => [
                "userName" => $userName,
            ],
        ]);
    }

    /**
     * This operation grants a specified role to the current user. Once granted the role, the user gets permissions allowed for the current role and can perform certain operations.To complete this operation, you need to enable authentication on your Milvus instance.
     */
    public function grantRole(string $userName, string $roleName)
    {
        return $this->client->post("/v2/vectordb/users/grant_role", [
            "json" => [
                "userName" => $userName,
                "roleName" => $roleName,
            ],
        ]);
    }

    /**
     * This operation lists the information of all existing users.
     */
    public function list()
    {
        return $this->client->post("/v2/vectordb/users/list", [
            "body" => "{}",
        ]);
    }

    /**
     * This operation revokes a privilege granted to the current role.
     */
    public function revokeRole(string $userName, string $roleName)
    {
        return $this->client->post("/v2/vectordb/users/revoke_role", [
            "json" => [
                "userName" => $userName,
                "roleName" => $roleName,
            ],
        ]);
    }

    /**
     * This operation updates the password for a specific user.
     */
    public function updatePassword(string $userName, string $password, string $newPassword)
    {
        return $this->client->post("/v2/vectordb/users/update_password", [
            "json" => [
                "userName" => $userName,
                "password" => $password,
                "newPassword" => $newPassword,
            ],
        ]);
    }
}
