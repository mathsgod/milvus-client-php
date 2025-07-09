<?php

namespace Milvus\Trait;

use Milvus\Databases;
use Milvus\Indexes;
use Milvus\IndexParams;

trait Management
{

    public function createIndex(string $collection_name, IndexParams $index_params)
    {
        (new Indexes($this))->create([
            'collectionName' => $collection_name,
            'indexParams' => $index_params
        ]);
    }

    public function listIndexes(string $collection_name): array
    {
        return (new Indexes($this))->list([
            'collectionName' => $collection_name
        ]);
    }


    /**
     * This operation releases the data of a specific collection from memory.
     */
    public function releaseCollection(string $collection_name)
    {
        return (new Collections($this))->release([
            'collectionName' => $collection_name
        ]);
    }
}
