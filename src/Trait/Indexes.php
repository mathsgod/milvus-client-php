<?php

namespace Milvus\Trait;

use Milvus\Indexes as MilvusIndexes;

trait Indexes
{
    public function createIndex(string $collection_name, $index_params)
    {
        return (new MilvusIndexes($this))->create([
            'collectionName' => $collection_name,
            'indexParams' => $index_params
        ]);
    }

    public function describeIndex(string $collection_name, string $index_name)
    {
        return (new MilvusIndexes($this))->describe([
            'collectionName' => $collection_name,
            'indexName' => $index_name
        ]);
    }

    public function dropIndexProperties(string $collection_name, string $index_name, array $property_keys)
    {
        return (new MilvusIndexes($this))->dropProperties([
            'collectionName' => $collection_name,
            'indexName' => $index_name,
            'propertyKeys' => $property_keys
        ]);
    }

    public function dropIndex(string $collection_name, string $index_name)
    {
        return (new MilvusIndexes($this))->drop([
            'collectionName' => $collection_name,
            'indexName' => $index_name
        ]);
    }

    public function listIndexes(string $collection_name)
    {
        return (new MilvusIndexes($this))->list([
            'collectionName' => $collection_name
        ]);
    }
}
