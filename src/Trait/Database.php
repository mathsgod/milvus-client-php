<?php

namespace Milvus\Trait;

use Milvus\Databases;

trait Database
{
    public function databases()
    {
        return new Databases($this);
    }

    public function create_database(string $database_name, ?array $properties = null)
    {
        return $this->databases()->create($database_name, $properties);
    }

    public function describe_database(string $db_name): array
    {
        return $this->databases()->describe($db_name);
    }

    public function drop_database(string $db_name)
    {
        return $this->databases()->drop($db_name);
    }

    public function drop_database_properties(string $db_name, array $property_keys)
    {
        return $this->databases()->dropProperties($db_name, $property_keys);
    }

    public function list_databases()
    {
        return $this->databases()->list();
    }
}
