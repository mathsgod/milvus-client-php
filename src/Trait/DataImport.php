<?php

namespace Milvus\Trait;

use Milvus\Http\JobsImport;

trait DataImport
{

    public function listImportJobs(?string $db_name = null)
    {
        return (new JobsImport($this))->list([
            'dbName' => $db_name ?? $this->dbName,
        ]);
    }


    public function createImportJob(
        string $collection_name,
        ?string $partition_name = null,
        ?array $files = null,
        ?array $options = null,

    ) {
        $params = [
            'dbName' => $this->dbName,
            'collectionName' => $collection_name,
            'partitionName' => $partition_name,
            'files' => $files,
            'options' => $options
        ];

        return (new JobsImport($this))->create(
            array_filter($params, fn ($value) => $value !== null)
        );
    }

    public function describeImportJob(string $job_id)
    {
        return (new JobsImport($this))->describe([
            'jobId' => $job_id
        ]);
    }
}
