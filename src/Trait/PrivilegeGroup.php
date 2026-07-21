<?php

namespace Milvus\Trait;

trait PrivilegeGroup
{
    public function createPrivilegeGroup(string $privilege_group_name, array $privileges = [])
    {
        return $this->privilegeGroups()->create([
            'privilegeGroupName' => $privilege_group_name,
            'privileges' => $privileges,
        ]);
    }

    public function dropPrivilegeGroup(string $privilege_group_name)
    {
        return $this->privilegeGroups()->drop([
            'privilegeGroupName' => $privilege_group_name,
        ]);
    }

    public function listPrivilegeGroups()
    {
        return $this->privilegeGroups()->list([
            'dbName' => $this->dbName,
        ]);
    }

    public function addPrivilegesToGroup(string $privilege_group_name, array $privileges)
    {
        return $this->privilegeGroups()->addPrivileges([
            'privilegeGroupName' => $privilege_group_name,
            'privileges' => $privileges,
        ]);
    }

    public function removePrivilegesFromGroup(string $privilege_group_name, array $privileges)
    {
        return $this->privilegeGroups()->removePrivileges([
            'privilegeGroupName' => $privilege_group_name,
            'privileges' => $privileges,
        ]);
    }
}
