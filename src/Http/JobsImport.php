<?php

namespace Milvus\Http;

use Milvus\Client;

class JobsImport
{

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create an import job to import data files into a Milvus collection.
     */
    public function create(array $params): array
    {
        return $this->client->post('/v2/vectordb/jobs/import/create', [
            'json' => $params
        ]);
    }

    /**
     * This operation gets the progress of the specified bulk-import job.
     */
    public function describe(array $params): array
    {
        return $this->client->post('/v2/vectordb/jobs/import/describe', [
            'json' => $params
        ]);
    }

    public function list(): array
    {
        return $this->client->post('/v2/vectordb/jobs/import/', [
            "body" => "{}"
        ]);
    }
}
