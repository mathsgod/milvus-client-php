<?php

namespace Milvus\Trait;

use Milvus\Http\Indexes as MilvusIndexes;

trait Indexes
{
    public function createIndex(string $collection_name, array $index_params)
    {
        return (new MilvusIndexes($this))->create([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'indexParams' => $index_params
        ]);
    }

    public function describeIndex(string $collection_name, string $index_name)
    {
        return (new MilvusIndexes($this))->describe([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'indexName' => $index_name
        ]);
    }

    public function dropIndexProperties(string $collection_name, string $index_name, array $property_keys)
    {
        return (new MilvusIndexes($this))->dropProperties([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'indexName' => $index_name,
            'propertyKeys' => $property_keys
        ]);
    }

    public function dropIndex(string $collection_name, string $index_name)
    {
        return (new MilvusIndexes($this))->drop([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'indexName' => $index_name
        ]);
    }

    public function listIndexes(string $collection_name)
    {
        return (new MilvusIndexes($this))->list([
            'dbName' => $this->dbName,
            'collectionName' => $collection_name
        ]);
    }
}
