<?php

namespace Milvus\Trait;

use Milvus\CollectionSchema;
use Milvus\IndexParams;
use Milvus\MetricType;

trait Collections
{
    public function collections()
    {
        return new \Milvus\Http\Collections($this);
    }

    /**
     * This operation flushes the streaming data and seals segments. It is recommended to call this operation after all the data has been inserted into a collection.
     */
    public function flushCollection(string $collection_name)
    {
        return $this->collections()->flush([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
        ]);
    }

    public function compactCollection(string $collection_name)
    {
        return $this->collections()->compact([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
        ]);
    }

    public function getCollectionLoadState(string $collection_name)
    {
        return $this->collections()->getLoadState([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
        ]);
    }

    public function refreshCollectionLoad(string $collection_name)
    {
        return $this->collections()->refreshLoad([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
        ]);
    }

    public function addCollectionFunction(string $collection_name, array $function)
    {
        return $this->collections()->addFunction([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'function' => $function,
        ]);
    }

    public function alterCollectionFunction(string $collection_name, string $function_name, array $function)
    {
        return $this->collections()->alterFunction([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'functionName' => $function_name,
            'function' => $function,
        ]);
    }

    public function describeExternalRefreshJob($job_id)
    {
        return $this->collections()->describeExternalRefreshJob([
            'jobId' => $job_id,
        ]);
    }

    public function dropCollectionFunction(string $collection_name, string $function_name)
    {
        return $this->collections()->dropFunction([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'FunctionName' => $function_name,
        ]);
    }

    public function getCompactionState($job_id)
    {
        return $this->collections()->getCompactionState([
            'jobID' => $job_id,
        ]);
    }

    public function listExternalRefreshJobs(?string $collection_name = null)
    {
        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
        ];

        return $this->collections()->listExternalRefreshJobs(
            array_filter($params, fn ($value) => $value !== null)
        );
    }

    public function refreshExternalCollection(
        string $collection_name,
        ?string $external_source = null,
        ?string $external_spec = null
    ) {
        if (($external_source === null) !== ($external_spec === null)) {
            throw new \InvalidArgumentException(
                'external_source and external_spec must be provided together.'
            );
        }

        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'externalSource' => $external_source,
            'externalSpec' => $external_spec,
        ];

        return $this->collections()->refreshExternal(
            array_filter($params, fn ($value) => $value !== null)
        );
    }

    public function runAnalyzer(
        array $text,
        ?string $analyzer_params = null,
        ?bool $with_detail = null,
        ?bool $with_hash = null,
        ?string $collection_name = null,
        ?string $field_name = null,
        ?array $analyzer_names = null
    ) {
        $params = [
            'dbName' => $this->dbName,
            'text' => $text,
            'analyzerParams' => $analyzer_params,
            'withDetail' => $with_detail,
            'withHash' => $with_hash,
            'collectionName' => $collection_name,
            'fieldName' => $field_name,
            'analyzerNames' => $analyzer_names,
        ];

        return $this->collections()->runAnalyzer(
            array_filter($params, fn ($value) => $value !== null)
        );
    }

    public function truncateCollection(string $collection_name)
    {
        return $this->collections()->truncate([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
        ]);
    }

    public function releaseCollection(string $collection_name)
    {
        return $this->collections()->release([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name
        ]);
    }

    public function loadCollection(string $collection_name)
    {
        return $this->collections()->load([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name
        ]);
    }

    /**
     * This operation reassigns the alias of one collection to another.
     */
    public function alterAlias(string $collection_name, string $alias_name)
    {
        return $this->aliases()->alter([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'aliasName' => $alias_name
        ]);
    }

    /**
     * This operation changes the specified collection field parameters.
     */
    public function alterCollectionField(
        string $collection_name,
        string $field_name,
        array $field_params
    ) {
        return $this->collections()->alterFieldProperties([
            'collectionName' => $collection_name,
            'fieldName' => $field_name,
            'fieldParams' => $field_params,
            'dbName' =>  $this->dbName,
        ]);
    }

    /**
     * This operation alters the specified collection properties.
     */
    public function alterCollectionProperties(string $collection_name, array $properties)
    {
        return $this->collections()->alterProperties([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'properties' => $properties
        ]);
    }

    /**
     * This operation creates an alias for an existing collection.
     */
    public function createAlias(string $collection_name, string $alias_name)
    {
        /** @var \Milvus\Client $this */
        return $this->aliases()->create([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'aliasName' => $alias_name
        ]);
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
        ?array $properties = null,
        ?string $description = null,
        ?int $partitions_num = null,
        ?bool $partition_key_isolation = null,
        ?string $ttl_field = null,
        ?array $warmup = null,
        ?int $max_length = null
    ) {
        $collection_params = $properties ?? [];
        if ($num_shards !== null) {
            $collection_params['shardsNum'] = $num_shards;
        }

        if ($enable_mmap !== null) {
            $collection_params['mmap.enabled'] = $enable_mmap;
        }

        if ($consistency_level !== null) {
            $collection_params['consistencyLevel'] = $consistency_level;
        }

        if ($partitions_num !== null) {
            $collection_params['partitionsNum'] = $partitions_num;
        }

        if ($partition_key_isolation !== null) {
            $collection_params['partitionKeyIsolation'] = $partition_key_isolation;
        }

        if ($ttl_field !== null) {
            $collection_params['ttlField'] = $ttl_field;
        }

        if ($max_length !== null) {
            $collection_params['max_length'] = $max_length;
        }

        if ($schema !== null && $description !== null) {
            $collection_params['description'] = $description;
        }

        if ($warmup !== null) {
            foreach ($warmup as $field => $value) {
                $key = str_starts_with($field, 'warmup.') ? $field : 'warmup.' . $field;
                $collection_params[$key] = $value;
            }
        }

        if (isset($properties["collection.ttl.seconds"])) {
            $collection_params['ttlSeconds'] = $properties["collection.ttl.seconds"];
            unset($collection_params['collection.ttl.seconds']);
        }

        /** @var \Milvus\Client $this */
        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'dimension' => $dimension,
            'idType' => $id_type,
            'primaryFieldName' => $primary_field_name,
            'vectorFieldName' => $vector_field_name,
            'metricType' => $metric_type,
            'autoID' => $auto_id,
            'schema' => $schema,
            'indexParams' => $index_params,
            'enableDynamicField' => $enable_dynamic_field,
            'description' => $schema === null ? $description : null,
            'params' => empty($collection_params) ? null : $collection_params
        ];

        return $this->collections()->create(
            array_filter($params, fn ($value) => $value !== null)
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
    public function describeAlias(string $alias_name): array
    {
        return $this->aliases()->describe([
            'dbName' => $this->dbName,
            'aliasName' => $alias_name
        ]);
    }

    /**
     * This operation lists detailed information about a specific collection.
     */
    public function describeCollection(string $collection_name)
    {
        return $this->collections()->describe([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name
        ]);
    }

    /**
     * This operation drops a specified collection alias.
     */
    public function dropAlias(string $alias_name)
    {
        return $this->aliases()->drop([
            'dbName' => $this->dbName,
            'aliasName' => $alias_name
        ]);
    }

    /**
     * This operation drops a collection.
     */
    public function dropCollection(string $collection_name)
    {
        return $this->collections()->drop([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name
        ]);
    }

    /**
     * This operation drops the specified collection properties.
     */
    public function dropCollectionProperties(string $collection_name, array $properties)
    {
        return $this->collections()->dropProperties([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'properties' => $properties
        ]);
    }

    /**
     * This operation lists the statistics collected on a specific collection.
     */
    public function getCollectionStats(string $collection_name): array
    {
        return $this->collections()->getStats([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name
        ]);
    }

    /**
     * This operation checks whether a specific collection exists.
     */
    public function hasCollection(string $collection_name): bool
    {
        return $this->collections()->has([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name
        ])["has"];
    }

    /**
     * This operation lists all existing aliases for a specific collection.
     */
    public function listAliases(string $collection_name)
    {
        return $this->aliases()->list([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name
        ]);
    }

    /**
     * This operation lists all existing collections.
     */
    public function listCollections()
    {
        return $this->collections()->list([
            'dbName' => $this->dbName
        ]);
    }

    /**
     * This operation renames an existing collection.
     */
    public function renameCollection(string $collection_name, string $new_collection_name)
    {
        return $this->collections()->rename([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'newCollectionName' => $new_collection_name
        ]);
    }
}
