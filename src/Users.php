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
    public function create(array $params)
    {
        return $this->client->post("/v2/vectordb/users/create", [
            "json" => $params,
        ]);
    }

    /**
     * This operation describes the detailed information of a specific user.
     */
    public function describe(array $params)
    {
        return $this->client->post("/v2/vectordb/users/describe", [
            "json" => $params,
        ]);
    }

    /**
     * This operation deletes an existing user.
     */
    public function drop(array $params)
    {
        return $this->client->post("/v2/vectordb/users/drop", [
            "json" => $params,
        ]);
    }

    /**
     * This operation grants a specified role to the current user. Once granted the role, the user gets permissions allowed for the current role and can perform certain operations.To complete this operation, you need to enable authentication on your Milvus instance.
     */
    public function grantRole(array $params)
    {
        return $this->client->post("/v2/vectordb/users/grant_role", [
            "json" => $params,
        ]);
    }

    /**
     * This operation lists the information of all existing users.
     */
    public function list(array $params = [])
    {
        return $this->client->post("/v2/vectordb/users/list", [
            "json" => $params,
        ]);
    }

    /**
     * This operation revokes a privilege granted to the current role.
     */
    public function revokeRole(array $params)
    {
        return $this->client->post("/v2/vectordb/users/revoke_role", [
            "json" => $params,
        ]);
    }

    /**
     * This operation updates the password for a specific user.
     */
    public function updatePassword(array $params)
    {
        return $this->client->post("/v2/vectordb/users/update_password", [
            "json" => $params,
        ]);
    }
}
