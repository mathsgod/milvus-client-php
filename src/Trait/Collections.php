<?php

namespace Milvus\Trait;

use Milvus\CollectionSchema;
use Milvus\IndexParams;
use Milvus\MetricType;

trait Collections
{

    public function loadCollection(string $collection_name)
    {
        return (new \Milvus\Collections($this))->load($collection_name);
    }


    /**
     * This operation reassigns the alias of one collection to another.
     */
    public function alterAlias(string $collection_name, string $alias)
    {
        $this->aliases()->alter($collection_name, $alias);
    }

    /**
     * This operation changes the specified collection field parameters.
     */
    public function alterCollectionField(
        string $collection_name,
        string $field_name,
        array $field_params,
        ?string $db_name = null
    ) {
        return (new \Milvus\Collections($this))->alterFieldProperties(
            $collection_name,
            $field_name,
            $field_params,
            $db_name,
        );
    }

    /**
     * This operation alters the specified collection properties.
     */
    public function alterCollectionProperties(string $collection_name, array $properties)
    {
        return (new \Milvus\Collections($this))->alterProperties($collection_name, $properties);
    }

    /**
     * This operation creates an alias for an existing collection.
     */
    public function createAlias(string $collection_name, string $alias)
    {
        /** @var \Milvus\Client $this */
        $this->aliases()->create($collection_name, $alias);
    }

    /**
     * This operation supports creating a collection in two distinct ways: quick setup or custom setup.
     */
    public function createCollection(
        string $collection_name,
        ?string $primary_field_name = "id",
        ?string $vector_field_name = "vector",
        ?string $metric_type = MetricType::COSINE,
        ?bool $auto_id = null,
        ?string $id_type = null,
        ?int $dimension = 0,
        ?CollectionSchema $schema = null,
        ?IndexParams $index_params = null,
        ?bool $enable_dynamic_field = null,
        ?int $num_shards = null,
        ?float $timeout = null,
        ?bool $enable_mmap = null,
        ?string $consistency_level = null,
        ?array $properties = null
    ) {


        $params = [];
        if ($num_shards !== null) {
            $params['shardsNum'] = $num_shards;
        }

        if ($enable_mmap !== null) {
            $params['mmap.enabled'] = $enable_mmap;
        }

        if ($consistency_level !== null) {
            $params['consistencyLevel'] = $consistency_level;
        }

        if (isset($properties["collection.ttl.seconds"])) {
            $params['ttlSeconds'] = $properties["collection.ttl.seconds"];
        }

        /** @var \Milvus\Client $this */
        (new \Milvus\Collections($this))->create(
            collectionName: $collection_name,
            dimension: $dimension,
            idType: $id_type,
            primaryFieldName: $primary_field_name,
            vectorFieldName: $vector_field_name,
            metricType: $metric_type,
            autoID: $auto_id,
            schema: $schema,
            indexParams: $index_params,
            enableDynamicField: $enable_dynamic_field,
            params: empty($params) ? null : $params

        );
    }

    /**
     * This operation creates a collection schema.
     */
    public function createSchema(
        ?bool $auto_id = null,
        ?bool $enable_dynamic_field = null,
        ?string $primary_field = null,
        ?string $partition_key_field = null,
    ) {
        return new CollectionSchema(
            fields: [],
            auto_id: $auto_id,
            enable_dynamic_field: $enable_dynamic_field,
            primary_field: $primary_field,
            partition_key_field: $partition_key_field,
        );
    }


    /**
     * This operation displays the details of an alias.
     */
    public function describeAlias(string $alias): array
    {
        return $this->aliases()->describe($alias);
    }


    /**
     * This operation lists detailed information about a specific collection.
     */
    public function describeCollection(string $collection_name)
    {
        return (new \Milvus\Collections($this))->describe($collection_name);
    }


    /**
     * This operation drops a specified collection alias.
     */
    public function dropAlias(string $alias)
    {
        $this->aliases()->drop($alias);
    }

    /**
     * This operation drops a collection.
     */
    public function dropCollection(string $collection_name)
    {
        (new \Milvus\Collections($this))->drop($collection_name);
    }

    /**
     * This operation drops the specified collection properties.
     */
    public function dropCollectionProperties(string $collection_name, array $property_keys)
    {
        return (new \Milvus\Collections($this))->dropProperties($collection_name, $property_keys);
    }

    /**
     * This operation lists the statistics collected on a specific collection.
     */
    public function getCollectionStats(string $collection_name): array
    {
        return (new \Milvus\Collections($this))->getStats($collection_name);
    }

    /**
     * This operation checks whether a specific collection exists.
     */
    public function hasCollection(string $collection_name): bool
    {
        return (new \Milvus\Collections($this))->has($collection_name)["has"];
    }


    /**
     * This operation lists all existing aliases for a specific collection.
     */
    public function listAliases(string $collection_name)
    {
        return $this->aliases()->list($collection_name);
    }

    /**
     * This operation lists all existing collections.
     */
    public function listCollections()
    {
        return (new \Milvus\Collections($this))->list();
    }

    /**
     * This operation renames an existing collection.
     */
    public function renameCollection(string $old_name, string $new_name)
    {
        return (new \Milvus\Collections($this))->rename($old_name, $new_name);
    }
}
