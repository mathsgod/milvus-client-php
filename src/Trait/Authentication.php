<?php

namespace Milvus\Trait;

trait Authentication
{
    public function createRole(string $role_name)
    {
        $this->roles()->create([
            'roleName' => $role_name
        ]);
    }

    public function createUser(string $user_name, string $password)
    {
        $this->users()->create([
            'userName' => $user_name,
            'password' => $password
        ]);
    }

    public function describeRole(string $role_name): array
    {
        return $this->roles()->describe([
            'roleName' => $role_name
        ]);
    }

    public function describeUser(string $user_name): array
    {
        return $this->users()->describe([
            'userName' => $user_name
        ]);
    }

    public function dropRole(string $role_name)
    {
        $this->roles()->drop([
            'roleName' => $role_name
        ]);
    }

    public function dropUser(string $user_name)
    {
        $this->users()->drop([
            'userName' => $user_name
        ]);
    }

    public function grantPrivilege(
        string $role_name,
        string $object_type,
        string $privilege,
        string $object_name
    ) {
        $this->roles()->grantPrivilege([
            'roleName' => $role_name,
            'objectType' => $object_type,
            'objectName' => $object_name,
            'privilege' => $privilege
        ]);
    }

    public function listRoles(): array
    {
        return $this->roles()->list();
    }

    public function listUsers(): array
    {
        return $this->users()->list();
    }

    public function revokeRole(string $user_name, string $role_name)
    {
        return $this->users()->revokeRole([
            'userName' => $user_name,
            'roleName' => $role_name
        ]);
    }

    public function updatePassword(string $user_name, string $old_password, string $new_password)
    {
        return $this->users()->updatePassword([
            'userName' => $user_name,
            'password' => $old_password,
            'newPassword' => $new_password
        ]);
    }
}
