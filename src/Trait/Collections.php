<?php

namespace Milvus\Trait;

use Milvus\CollectionSchema;
use Milvus\IndexParams;
use Milvus\MetricType;

trait Collections
{


    public function load_collection(string $collection_name)
    {
        return $this->collections()->load($collection_name);
    }


    /**
     * This operation reassigns the alias of one collection to another.
     */
    public function alter_alias(string $collection_name, string $alias)
    {
        $this->aliases()->alter($collection_name, $alias);
    }

    /**
     * This operation changes the specified collection field parameters.
     */
    public function alter_collection_field(
        string $collection_name,
        string $field_name,
        array $field_params,
        string $db_name = ""
    ) {
        return $this->collections()->alterFieldProperties(
            $collection_name,
            $field_name,
            $field_params,
            $db_name,
        );
    }

    /**
     * This operation alters the specified collection properties.
     */
    public function alter_collection_properties(string $collection_name, array $properties)
    {
        return $this->collections()->alterProperties($collection_name, $properties);
    }

    /**
     * This operation creates an alias for an existing collection.
     */
    public function create_alias(string $collection_name, string $alias)
    {
        /** @var \Milvus\Client $this */
        $this->aliases()->create($collection_name, $alias);
    }

    /**
     * This operation supports creating a collection in two distinct ways: quick setup or custom setup.
     */
    public function create_collection(
        string $collection_name,
        ?int $dimension = 0,
        string $primary_field_name = "id",
        string $vector_field_name = "vector",
        string $metric_type = MetricType::COSINE,
        bool $auto_id = false,
        ?float $timeout = null,
        ?CollectionSchema $schema = null,
        ?IndexParams $index_params = null,
        ?bool $enable_dynamic_field = false
    ) {
        /** @var \Milvus\Client $this */
        return $this->collections()->create(
            $collection_name,
            $dimension,
            $primary_field_name,
            $vector_field_name,
            $metric_type,
            $auto_id,
            $timeout,
            $schema,
            $index_params,
            $enable_dynamic_field
        );
    }

    /**
     * This operation creates a collection schema.
     */
    public function create_schema(bool $auto_id = false, bool $enable_dynamic_field = false)
    {
        return new CollectionSchema($auto_id, $enable_dynamic_field);
    }


    /**
     * This operation displays the details of an alias.
     */
    public function describe_alias(string $alias): array
    {
        return $this->aliases()->describe($alias);
    }


    /**
     * This operation lists detailed information about a specific collection.
     */
    public function describe_collection(string $collection_name)
    {
        return $this->collections()->describe($collection_name);
    }


    /**
     * This operation drops a specified collection alias.
     */
    public function drop_alias(string $alias)
    {
        $this->aliases()->drop($alias);
    }

    /**
     * This operation drops a collection.
     */
    public function drop_collection(string $collection_name)
    {
        return $this->collections()->drop($collection_name);
    }

    /**
     * This operation drops the specified collection properties.
     */
    public function drop_collection_properties(string $collection_name, array $property_keys)
    {
        return $this->collections()->dropProperties($collection_name, $property_keys);
    }

    /**
     * This operation lists the statistics collected on a specific collection.
     */
    public function get_collection_stats(string $collection_name): array
    {
        return $this->collections()->getStats($collection_name);
    }

    /**
     * This operation checks whether a specific collection exists.
     */
    public function has_collection(string $collection_name): bool
    {
        return $this->collections()->has($collection_name)["has"];
    }


    /**
     * This operation lists all existing aliases for a specific collection.
     */
    public function list_aliases(string $collection_name)
    {
        return $this->aliases()->list($collection_name);
    }

    /**
     * This operation lists all existing collections.
     */
    public function list_collections()
    {
        return $this->collections()->list();
    }

    /**
     * This operation renames an existing collection.
     */
    public function rename_collection(string $old_name, string $new_name)
    {
        return $this->collections()->rename($old_name, $new_name);
    }
}
