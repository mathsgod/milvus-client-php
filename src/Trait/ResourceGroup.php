<?php

namespace Milvus\Trait;

trait ResourceGroup
{
    public function resourceGroups()
    {
        return new \Milvus\Http\ResourceGroups($this);
    }

    public function createResourceGroup(string $group_name, ?array $properties = null)
    {
        return $this->resourceGroups()->create([
            'groupName' => $group_name,
            'properties' => $properties,
        ]);
    }

    public function describeResourceGroup(string $group_name): array
    {
        return $this->resourceGroups()->describe([
            'groupName' => $group_name
        ]);
    }

    public function dropResourceGroup(string $group_name)
    {
        return $this->resourceGroups()->drop([
            'groupName' => $group_name
        ]);
    }

    public function listResourceGroups()
    {
        return $this->resourceGroups()->list();
    }

    public function transferReplica(string $source_rg_name, string $target_rg_name, string $collection_name, int $replica_num)
    {
        return $this->resourceGroups()->transferReplica([
            'sourceRgName' => $source_rg_name,
            'targetRgName' => $target_rg_name,
            'collectionName' => $collection_name,
            'replicaNum' => $replica_num
        ]);
    }

    public function alterResourceGroup() {

        //todo: implement alter resource group
    }
}
