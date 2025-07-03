<?php

namespace Milvus;

class Client
{
    use Trait\Authentication;
    use Trait\Collections;
    use Trait\Vector;
    use Trait\Management;
    use Trait\Database;

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


    //--- START OF DATABASES ---

    public function usingDatabase(string $db_name)
    {
        $this->dbName = $db_name;
    }
    //--- END OF DATABASES ---


    protected function aliases()
    {
        return new Aliases($this);
    }



    public function collections()
    {
        return new Collections($this);
    }

    public function databases()
    {
        return new Databases($this);
    }

    public function entities()
    {
        return new Entities($this);
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

  


    public  function roles()
    {
        return new Roles($this);
    }

    public function users()
    {
        return new Users($this);
    }

}
