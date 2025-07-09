<?php

namespace Milvus\Trait;

use Milvus\Http\JobsImport;

trait DataImport
{

    public function listImportJobs()
    {
        return (new JobsImport($this))->list();
    }


    public function createImportJob(
        string $collection_name,
        ?string $partition_name = null,
        ?array $files = null,
        ?array $options = null,

    ) {
        return (new JobsImport($this))->create([
            'collectionName' => $collection_name,
            'partitionName' => $partition_name,
            'files' => $files,
            'options' => $options
        ]);
    }

    public function describeImportJob(string $job_id)
    {
        return (new JobsImport($this))->describe([
            'jobId' => $job_id
        ]);
    }
}
