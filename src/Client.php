<?php

namespace Milvus;

use Milvus\Http\Aliases;
use Milvus\Http\Databases;
use Milvus\Http\Entities;
use Milvus\Http\Partitions;
use Milvus\Http\Roles;
use Milvus\Http\Users;

class Client
{
    use Trait\Authentication;
    use Trait\Collections;
    use Trait\Vector;
    use Trait\Database;
    use Trait\Partitions;
    use Trait\ResourceGroup;
    use Trait\DataImport;
    use Trait\Indexes;

    private $client;
    private $dbName = "default";
    public function __construct(
        string $uri = "http://localhost:19530",
        ?string $user = null,
        ?string $password = null,
        ?string $db_name = "default",
        ?string $token = null,
        ?float $timeout = null,
        bool|string $verify = true,
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
            "verify" => $verify,
            "headers" => $headers,
            "timeout" => $timeout
        ]);
    }


    //--- START OF DATABASES ---

    public function usingDatabase(string $db_name)
    {
        $this->dbName = $db_name;
    }
    //--- END OF DATABASES ---


    public function aliases()
    {
        return new Aliases($this);
    }

    public function databases()
    {
        return new Databases($this);
    }

    public function entities()
    {
        return new Entities($this);
    }


    public function partitions()
    {
        return new Partitions($this);
    }

    public function post($uri, array $options = []): array
    {
        if (isset($options['json']) && (empty($options['json']) || $options['json'] === [])) {
            unset($options['json']);
            $options['body'] = "{}";
        }

        $response = $this->client->post($uri, $options);

        $data = json_decode($response->getBody()->getContents(), true);

        if (!is_array($data) || !array_key_exists('code', $data)) {
            throw new \UnexpectedValueException('Milvus returned an invalid JSON response.');
        }

        $code = (int) $data['code'];
        if ($code !== 0) {
            throw new \Exception($data['message'] ?? 'Milvus request failed.', $code);
        }

        return $data['data'] ?? [];
    }

    public function prepareIndexParams()
    {
        return new IndexParams();
    }

    public function roles()
    {
        return new Roles($this);
    }

    public function users()
    {
        return new Users($this);
    }
}
