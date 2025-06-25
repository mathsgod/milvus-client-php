<?php

namespace Milvus;

class Client
{
    private $client;
    public function __construct(
        string $uri = "http://localhost:19530",
        ?string $user = null,
        ?string $password = null,
        ?string $db_name = null,
        ?string $token = null,
        ?float $timeout = null,
    ) {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $uri,
            "verify" => false,
            "headers" => [
                "Content-Type" => "application/json",
            ]
        ]);
    }

    public function createSchema(bool $auto_id = false, bool $enable_dynamic_field = false)
    {
        return new CollectionSchema($auto_id, $enable_dynamic_field);
    }

    public function dropCollection(string $collection_name)
    {
        return $this->collections()->drop($collection_name);
    }

    public function listCollections()
    {
        return $this->collections()->list();
    }

    public function renameCollection(string $old_name, string $new_name)
    {
        return $this->collections()->rename($old_name, $new_name);
    }




    public function prepareIndexParams()
    {

        return new IndexParams();
    }

    public function insert(
        string $collection_name,
        array $data,
    ) {
        return (new Entities($this))->insert($collection_name, $data);
    }

    public function upsert(
        string $collection_name,
        array $data,
    ) {
        return (new Entities($this))->upsert($collection_name, $data);
    }

    public function delete(
        string $collection_name,
        ?string $filter = null,
        ?array $ids = null
    ) {
        return (new Entities($this))->delete($collection_name, $filter, $ids);
    }

    public function createDatabase(string $database_name, ?array $properties = null)
    {
        return $this->databases()->create($database_name, $properties);
    }


    public function createCollection(
        string $collection_name,
        ?int $dimension = 0,
        string $primary_field_name = "id",
        string $vector_field_name = "vector",
        string $metric_type = "CONSINE",
        bool $auto_id = false,
        ?float $timeout = null,
        ?CollectionSchema $schema = null,
        ?IndexParams $index_params = null
    ) {
        return $this->collections()->create(
            $collection_name,
            $dimension,
            $primary_field_name,
            $vector_field_name,
            $metric_type,
            $auto_id,
            $timeout,
            $schema,
            $index_params
        );
    }


    public function listDatabases()
    {
        return $this->databases()->list();
    }


    public function databases()
    {
        return new Databases($this);
    }

    public function aliases()
    {
        return new Aliases($this);
    }

    public function partitions(string $collectionName)
    {
        return new Partitions($this, $collectionName);
    }

    public function entities(string $collectionName)
    {
        return new Entities($this, $collectionName);
    }

    public function collections()
    {
        return new Collections($this);
    }

    public function role(string $roleName)
    {
        return new Role($this, $roleName);
    }

    public function roles()
    {
        return new Roles($this);
    }

    public function users()
    {
        return new Users($this);
    }

    public function user(string $userName)
    {
        return new User($this, $userName);
    }

    public function post($uri, array $options = []): array
    {
        $response = $this->client->post($uri, $options);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data["code"] !== 0)
            throw new \Exception($data["message"], $data["code"]);

        return $data["data"];
    }

    public function search(string $collection_name, string $anns_field, array $data, int $limit, ?array $search_params)
    {
        return (new Entities($this))->search(
            $collection_name,
            $anns_field,
            $data,
            $limit,
            $search_params
        );
    }
}
