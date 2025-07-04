<?php

namespace Milvus\Trait;

use Milvus\Databases;
use Milvus\Indexes;
use Milvus\IndexParams;

trait Management
{

    public function createIndex(string $collection_name, IndexParams $index_params)
    {
        (new Indexes($this))->create($collection_name, $index_params);
    }

    public function listIndexes(string $collection_name): array
    {
        return (new Indexes($this))->list($collection_name);
    }


    /**
     * This operation releases the data of a specific collection from memory.
     */
    public function releaseCollection(string $collection_name)
    {
        return (new Collections($this))->release($collection_name);
    }
}
