<?php

namespace Milvus;

class Client
{
    private $client;
    public function __construct(string $server = "localhost", int $port = 9091)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => "http://$server:$port"
        ]);
    }

    public function listRoles()
    {
        $response = $this->client->get('/api/v1/users');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function describeIndex(array $params)
    {
        $response = $this->client->get('/api/v1/index', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCollection(string $name)
    {
        return new Collection($this, $name);
    }

    public function query(array $params)
    {
        $response = $this->client->post('/api/v1/query', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function releasePartitions(array $params)
    {
        $response = $this->client->delete('/api/v1/partition/load', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function loadPartitions(array $params)
    {
        $response = $this->client->post('/api/v1/partition/load', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }


    public function dropPartition(array $params)
    {
        $response = $this->client->delete('/api/v1/partition', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function showPartitions(array $params)
    {
        $response = $this->client->get('/api/v1/partitions', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function hasPartition(array $params)
    {
        $response = $this->client->get('/api/v1/partition/existence', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function createPartition(array $params)
    {
        $response = $this->client->post('/api/v1/partition', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function releaseCollection(array $params)
    {
        $response = $this->client->delete('/api/v1/collection/load', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function loadCollection(array $params)
    {
        $response = $this->client->post('/api/v1/collection/load', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function search(array $params)
    {
        $response = $this->client->post('/api/v1/search', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function createIndex(array $params)
    {
        $response = $this->client->post('/api/v1/index', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function dropIndex(array $params)
    {
        $response = $this->client->delete('/api/v1/index', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function hasCollection(array $params)
    {
        $response = $this->client->get('/api/v1/collection', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }


    public function dropCollection(array $params)
    {
        $response = $this->client->delete("/api/v1/collection", [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function describeCollection(array $params)
    {
        $response = $this->client->get('/api/v1/collection', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function deleteEntities(array $params)
    {
        $response = $this->client->delete('/api/v1/entities', [
            'json' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function insert(array $params)
    {
        $collection_name = $params['collection_name'];

        $collection = $this->describeCollection(['collection_name' => $collection_name]);
        $fields = $collection["schema"]["fields"];


        $fields_data = $params['fields_data'];
        $num_rows = count($fields_data);

        //flatten array
        $data = [];
        foreach ($fields as $field) {
            $data[] = [
                "field_name" => $field["name"],
                "type" => $field["data_type"],
                "field" => []
            ];
        }

        foreach ($fields_data as $fd) {
            foreach ($data as &$d) {
                $d["field"][] = $fd[$d["field_name"]];
            }
        }




        $response = $this->client->request('POST', '/api/v1/entities', [
            'json' => [
                "collection_name" => $params["collection_name"],
                "fields_data" => $data,
                "num_rows" => $num_rows,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createCollection(array $params)
    {
        $params["schema"]["name"] = $params["collection_name"];

        $response = $this->client->post('/api/v1/collection', [
            'json' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function showCollections()
    {
        $response = $this->client->get('/api/v1/collections');
        $body = $response->getBody();

        $result = '';
        while (!$body->eof()) {
            $result .= $body->read(1024);
        }
        return json_decode($result, true);
    }
}
