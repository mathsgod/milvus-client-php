<?php

namespace Milvus;

class Job
{

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create an import job to import data files into a Milvus collection.
     */
    public function createImportJob(
        string $collectionName,
        ?string $partitionName = null,
        array $files,
        array $options = [],
    ): array {

        return $this->client->post('/v2/vectordb/jobs/import/create', [
            'json' => [
                'collectionName' => $collectionName,
                'partitionName' => $partitionName,
                'files' => $files,
                'options' => $options
            ]
        ]);
    }

    /**
     * This operation gets the progress of the specified bulk-import job.
     */
    public function describeImportJob(string $jobId): array
    {
        return $this->client->post('/v2/vectordb/jobs/import/describe', [
            'json' => [
                'jobId' => $jobId
            ]
        ]);
    }

    public function list(): array
    {
        return $this->client->post('/v2/vectordb/jobs/import/', [
            "body" => "{}"
        ]);
    }
}
