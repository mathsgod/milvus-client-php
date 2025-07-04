<?php

namespace Milvus\Trait;

trait Authentication
{
    public function createRole(string $role_name)
    {
        $this->roles()->create($role_name);
    }

    public function createUser(string $user_name, string $password)
    {
        $this->users()->create($user_name, $password);
    }

    public function describeRole(string $role_name): array
    {
        return $this->roles()->describe($role_name);
    }

    public function describeUser(string $user_name): array
    {
        return $this->users()->describe($user_name);
    }

    public function dropRole(string $role_name)
    {
        $this->roles()->drop($role_name);
    }

    public function dropUser(string $user_name)
    {
        $this->users()->drop($user_name);
    }

    public function grantPrivilege(
        string $role_name,
        string $object_type,
        string $privilege,
        string $object_name
    ) {
        $this->roles()->grantPrivilege(
            $role_name,
            $object_type,
            $privilege,
            $object_name
        );
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
        return $this->users()->revokeRole($user_name, $role_name);
    }

    public function updatePassword(string $user_name, string $old_password, string $new_password)
    {
        return $this->users()->updatePassword($user_name, $old_password, $new_password);
    }
}
