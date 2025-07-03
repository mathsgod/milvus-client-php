<?php

namespace Milvus\Trait;

use Milvus\CollectionSchema;
use Milvus\IndexParams;
use Milvus\MetricType;

trait Collections
{

    public function get_collection_stats(string $collection_name): array
    {
        return $this->collections()->getStats($collection_name);
    }

    public function has_collection(string $collection_name): bool
    {
        return $this->collections()->has($collection_name)["has"];
    }

    public function describe_alias(string $alias): array
    {
        return $this->aliases()->describe($alias);
    }

    public function describe_collection(string $collection_name)
    {
        return $this->collections()->describe($collection_name);
    }

    public function drop_alias(string $alias)
    {
        $this->aliases()->drop($alias);
    }

    public function drop_collection(string $collection_name)
    {
        return $this->collections()->drop($collection_name);
    }

    public function drop_collection_properties(string $collection_name, array $property_keys)
    {
        return $this->collections()->dropProperties($collection_name, $property_keys);
    }

    public function list_aliases(string $collection_name)
    {
        return $this->aliases()->list($collection_name);
    }

    public function list_collections()
    {
        return $this->collections()->list();
    }

    public function create_alias(string $collection_name, string $alias)
    {
        /** @var \Milvus\Client $this */
        $this->aliases()->create($collection_name, $alias);
    }

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

    public function create_schema(bool $auto_id = false, bool $enable_dynamic_field = false)
    {
        return new CollectionSchema($auto_id, $enable_dynamic_field);
    }
}
