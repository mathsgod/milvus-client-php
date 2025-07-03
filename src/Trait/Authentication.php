<?php

namespace Milvus\Trait;

trait Authentication
{
    public function create_role(string $role_name)
    {
        $this->roles()->create($role_name);
    }

    public function create_user(string $user_name, string $password)
    {
        $this->users()->create($user_name, $password);
    }

    public function describe_role(string $role_name): array
    {
        return $this->roles()->describe($role_name);
    }

    public function describe_user(string $user_name): array
    {
        return $this->users()->describe($user_name);
    }

    public function drop_role(string $role_name)
    {
        $this->roles()->drop($role_name);
    }

    public function drop_user(string $user_name)
    {
        $this->users()->drop($user_name);
    }

    public function grant_privilege(
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
    public function list_roles(): array
    {
        return $this->roles()->list();
    }

    public function list_users(): array
    {
        return $this->users()->list();
    }

    public function revoke_role(string $user_name, string $role_name)
    {
        return $this->users()->revokeRole($user_name, $role_name);
    }

    public function update_password(string $user_name, string $old_password, string $new_password)
    {
        return $this->users()->updatePassword($user_name, $old_password, $new_password);
    }
}
