<?php

namespace Milvus;

/**
 * Class for common collection property keys.
 */
class DatabaseProperty
{
    /**
     * The number of replicas for the specified database.
     * @var string
     */
    const REPLICA_NUMBER = 'database.replica.number';

    /**
     * The names of the resource groups associated with the specified database in a comma-separated list.
     */
    const RESOURCE_GROUPS = 'database.resource_groups';

    /**
     * The maximum size of the disk space for the specified database, in megabytes (MB).
     */
    const DISK_QUOTA_MB = 'database.diskQuota.mb';

    /**
     * The maximum number of collections allowed in the specified database.
     */
    const MAX_COLLECTIONS = 'database.max.collections';

    /**
     * Whether to force the specified database to deny writing operations.
     */
    const FORCE_DENY_WRITING = 'database.force.deny.writing';

    /**
     * Whether to force the specified database to deny reading operations.
     */
    const FORCE_DENY_READING = 'database.force.deny.reading';
}
