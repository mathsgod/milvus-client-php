<?php

namespace Milvus\Trait;

use Milvus\Partitions as MilvusPartitions;

trait Partitions
{

    public function createPartition(string $collection_name, string $partition_name)
    {
        return (new MilvusPartitions($this))->create($collection_name, $partition_name);
    }

    public function dropPartition(string $collection_name, string $partition_name)
    {
        return (new MilvusPartitions($this))->drop($collection_name, $partition_name);
    }

    public function getPartitionStats(string $collection_name, string $partition_name)
    {
        return (new MilvusPartitions($this))->getStats($collection_name, $partition_name);
    }

    public function hasPartition(string $collection_name, string $partition_name): bool
    {
        return (new MilvusPartitions($this))->has($collection_name, $partition_name)["has"];
    }

    public function listPartitions(string $collection_name): array
    {
        return (new MilvusPartitions($this))->list($collection_name);
    }

    public function loadPartition(string $collection_name, string|array $partition_name)
    {
        if (is_string($partition_name)) {
            $partition_name = [$partition_name];
        }
        return (new MilvusPartitions($this))->load($collection_name, $partition_name);
    }

    public function releasePartition(string $collection_name, string|array $partition_name)
    {
        if (is_string($partition_name)) {
            $partition_name = [$partition_name];
        }
        return (new MilvusPartitions($this))->release($collection_name, $partition_name);
    }
}
