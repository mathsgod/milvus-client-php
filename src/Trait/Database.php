<?php

namespace Milvus\Trait;

use Milvus\Databases;

trait Database
{
    public function databases()
    {
        return new Databases($this);
    }

    public function createDatabase(string $database_name, ?array $properties = null)
    {
        return $this->databases()->create([
            'dbName' => $database_name,
            'properties' => $properties,
        ]);
    }

    public function describeDatabase(string $db_name): array
    {
        return $this->databases()->describe([
            'dbName' => $db_name
        ]);
    }

    public function dropDatabase(string $db_name)
    {
        return $this->databases()->drop([
            'dbName' => $db_name
        ]);
    }

    public function dropDatabaseProperties(string $db_name, array $property_keys)
    {
        return $this->databases()->dropProperties([
            'dbName' => $db_name,
            'propertyKeys' => $property_keys
        ]);
    }

    public function listDatabases()
    {
        return $this->databases()->list();
    }
}
