<?php

namespace Milvus;

class Client
{
    private $client;
    private $dbName = "default";
    public function __construct(
        string $uri = "http://localhost:19530",
        ?string $user = null,
        ?string $password = null,
        ?string $db_name = "default",
        ?string $token = null,
        ?float $timeout = null,
    ) {
        $headers = [
            "Content-Type" => "application/json",
        ];

        if ($token) {
            $headers["Authorization"] = "Bearer " . $token;
        }

        if ($user && $password) {
            $headers["Authorization"] = "Bearer $user:$password";
        }

        if ($db_name) {
            $this->dbName = $db_name;
        }


        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $uri,
            "verify" => false,
            "headers" => $headers,
        ]);
    }

    public function hybridSearch(
        string $collection_name,
        array $reqs,
        ?array $ranker = null,
        ?int $limit = null,
        ?array $outputFields = []
    ) {
        return (new Entities($this))->hybridSearch(
            $collection_name,
            $reqs,
            $ranker,
            $limit,
            $outputFields
        );
    }

    //--- START OF DATABASES ---
    public function createDatabase(string $database_name, ?array $properties = null)
    {
        return $this->databases()->create($database_name, $properties);
    }

    public function describeDatabase(string $db_name): array
    {
        return $this->databases()->describe($db_name);
    }

    public function dropDatabase(string $db_name)
    {
        return $this->databases()->drop($db_name);
    }

    public function dropDatabaseProperties(string $db_name, array $property_keys)
    {
        return $this->databases()->dropProperties($db_name, $property_keys);
    }

    public function listDatabases()
    {
        return $this->databases()->list();
    }

    public function usingDatabase(string $db_name)
    {
        $this->dbName = $db_name;
    }
    //--- END OF DATABASES ---


    private function aliases()
    {
        return new Aliases($this);
    }

    public function alterAlias(string $collection_name, string $alias)
    {
        $this->aliases()->alter($collection_name, $alias);
    }

    public function alterCollectionField(
        string $collection_name,
        string $field_name,
        array $field_params,
        string $db_name = ""
    ) {
        return $this->collections()->alterFieldProperties(
            $collection_name,
            $field_name,
            $field_params,
            $db_name,
        );
    }

    public function alterCollectionProperties(string $collection_name, array $properties)
    {
        return $this->collections()->alterProperties($collection_name, $properties);
    }

    private function collections()
    {
        return new Collections($this);
    }

    public function createAlias(string $collection_name, string $alias)
    {
        $this->aliases()->create($collection_name, $alias);
    }


    //--- Authentication ---
    public function createRole(string $role_name)
    {
        $this->roles()->create($role_name);
    }

    public function createUser(string $user_name, string $password)
    {
        $this->users()->create($user_name, $password);
    }

    public function describeRole(string $role_name): array
    {
        return $this->roles()->describe($role_name);
    }

    public function describeUser(string $user_name): array
    {
        return $this->users()->describe($user_name);
    }

    public function dropRole(string $role_name)
    {
        $this->roles()->drop($role_name);
    }

    public function dropUser(string $user_name)
    {
        $this->users()->drop($user_name);
    }

    public function grantPrivilege(
        string $role_name,
        string $object_type,
        string $privilege,
        string $object_name
    ) {
        $this->roles()->grantPrivilege(
            $role_name,
            $object_type,
            $privilege,
            $object_name
        );
    }
    public function listRoles(): array
    {
        return $this->roles()->list();
    }

    public function listUsers(): array
    {
        return $this->users()->list();
    }

    public function updatePassword(string $user_name, string $old_password, string $new_password)
    {
        return $this->users()->updatePassword($user_name, $old_password, $new_password);
    }
    //--- End of Authentication ---


    //-- Start of Collections ---
    public function createCollection(
        string $collection_name,
        ?int $dimension = 0,
        string $primary_field_name = "id",
        string $vector_field_name = "vector",
        string $metric_type = "COSINE",
        bool $auto_id = false,
        ?float $timeout = null,
        ?CollectionSchema $schema = null,
        ?IndexParams $index_params = null,
        ?bool $enable_dynamic_field = false
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
            $index_params,
            $enable_dynamic_field
        );
    }

    public function createSchema(bool $auto_id = false, bool $enable_dynamic_field = false)
    {
        return new CollectionSchema($auto_id, $enable_dynamic_field);
    }

    public function databases()
    {
        return new Databases($this);
    }

    public function delete(
        string $collection_name,
        ?string $filter = null,
        ?array $ids = null
    ) {

        if ($ids !== null) {
            $filter = "id in [" . implode(',', $ids) . "]";
        }

        return (new Entities($this))->delete($collection_name, $filter);
    }

    public function describeAlias(string $alias): array
    {
        return $this->aliases()->describe($alias);
    }

    public function describeCollection(string $collection_name)
    {
        return $this->collections()->describe($collection_name);
    }

    public function dropAlias(string $alias)
    {
        $this->aliases()->drop($alias);
    }

    public function dropCollection(string $collection_name)
    {
        return $this->collections()->drop($collection_name);
    }

    public function dropCollectionProperties(string $collection_name, array $property_keys)
    {
        return $this->collections()->dropProperties($collection_name, $property_keys);
    }

    public function entities()
    {
        return new Entities($this);
    }

    public function getCollectionStats(string $collection_name): array
    {
        return $this->collections()->getStats($collection_name);
    }

    public function hasCollection(string $collection_name): bool
    {
        return $this->collections()->has($collection_name)["has"];
    }


    public function insert(
        string $collection_name,
        array $data,
    ) {
        return $this->entities()->insert($collection_name, $data);
    }

    public function listAliases(string $collection_name)
    {
        return $this->aliases()->list($collection_name);
    }

    public function listCollections()
    {
        return $this->collections()->list();
    }


    public function loadCollection(string $collection_name)
    {
        return $this->collections()->load($collection_name);
    }

    public function partitions(string $collectionName)
    {
        return new Partitions($this, $collectionName);
    }

    public function post($uri, array $options = []): array
    {
        $response = $this->client->post($uri, $options);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data["code"] !== 0)
            throw new \Exception($data["message"], $data["code"]);

        return $data["data"];
    }

    public function prepareIndexParams()
    {
        return new IndexParams();
    }

    public function releaseCollection(string $collection_name)
    {
        return $this->collections()->release($collection_name);
    }

    public function renameCollection(string $old_name, string $new_name)
    {
        return $this->collections()->rename($old_name, $new_name);
    }

    public  function roles()
    {
        return new Roles($this);
    }

    public function query(
        string $collection_name,
        string $filter,
        ?array $output_fields = null
    ) {
        return (new Entities($this))
            ->query(
                collectionName: $collection_name,
                filter: $filter,
                outputFields: $output_fields
            );
    }


    public function search(
        string $collection_name,
        array $data,
        string $filter = "",
        int $limit = 10,
        ?array $output_fields = null,
        ?array $search_params = null,
        ?string $anns_field = null,
        ?array $partition_names = null,

    ) {
        return (new Entities($this))->search(
            collectionName: $collection_name,
            data: $data,
            annsField: $anns_field,
            limit: $limit,
            searchParams: $search_params,
            partitionNames: $partition_names,
        );
    }

    public function upsert(
        string $collection_name,
        array $data,
        ?string $partition_name = null
    ) {
        return $this->entities()->upsert($collection_name, $data, $partition_name);
    }

    public function users()
    {
        return new Users($this);
    }


    //--- Start of Management ---

    public function createIndex(string $collection_name, IndexParams $index_params)
    {
        (new Indexes($this))->create($collection_name, $index_params);
    }

    public function listIndexes(string $collection_name): array
    {
        return (new Indexes($this))->list($collection_name);
    }
}
