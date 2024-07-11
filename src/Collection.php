<?php

namespace Milvus;

use Exception;

class Collection
{
    private $client;
    private $collectionName;

    public function __construct(Client $client, $collectionName)
    {
        $this->client = $client;
        $this->collectionName = $collectionName;
    }

    public function describe()
    {
        return $this->client->post("/v2/vectordb/collections/describe", [
            "json" => [
                "collectionName" => $this->collectionName
            ],
        ]);
    }


    public function release()
    {
        return $this->client->post('/v2/vectordb/collections/release', [
            'json' => [
                'collectionName' => $this->collectionName
            ]
        ]);
    }

    public function load()
    {
        return $this->client->post('/v2/vectordb/collections/load', [
            'json' => [
                'collectionName' => $this->collectionName
            ]
        ]);
    }

    public function getStats()
    {
        return $this->client->post('/v2/vectordb/collections/get_stats', [
            'json' => [
                'collectionName' => $this->collectionName
            ]
        ]);
    }


    public function __debugInfo()
    {
        return [
            "collectionName" => $this->collectionName
        ];
    }

    public function entities()
    {
        return new Entities($this->client, $this->collectionName);
    }



    /* 
    

    public function getAliases()
    {
        $desc = $this->client->describeCollection($this->name);
        return $desc["aliases"];
    }

    public function dropAlias(string $name)
    {
        $this->client->dropAlias($name);
    }

    public function deleteEntities(string $expr)
    {
        return $this->client->deleteEntities($this->name, $expr);
    }

    public function dropIndex()
    {
        $this->client->dropIndex([
            "collection_name" => $this->name,
        ]);
    }

    public function insert(array $data)
    {
        return $this->client->insert([
            "collection_name" => $this->name,
            "fields_data" => $data
        ]);
    }

    public function hasPartition(string $name)
    {
        $data = $this->client->hasPartition([
            "collection_name" => $this->name,
            "partition_name" => $name
        ]);

        return isset($data["value"]) && $data["value"] == 1;
    }

    public function showPartitions()
    {
        $data = $this->client->showPartitions([
            "collection_name" => $this->name
        ]);
        return $data;
    }

    public function getPartitions()
    {
        $data = $this->client->showPartitions([
            "collection_name" => $this->name
        ]);

        $parts = [];

        foreach ($data["partition_names"] as $index => $name) {

            $parts[] = new Partition($this->client, $this, $name);
        }
        return $parts;
    }


    public function release()
    {
        return $this->client->releaseCollection([
            "collection_name" => $this->name
        ]);
    }

    public function drop()
    {
        return $this->client->dropCollection($this->name);
    }

    public function load()
    {
        $ret = $this->client->loadCollection($this->name);

        if (isset($ret["error_code"])) {
            throw new Exception($ret["reason"], $ret["error_code"]);
        }
        return $ret;
    }

    public function getPrimaryKeyField()
    {
        foreach ($this->getFields() as $field) {
            if ($field->is_primary_key) {
                return $field;
            }
        }

        return null;
    }

    public function query(string $expr, array $output_fields = [])
    {
        $data = $this->client->query([
            "collection_name" => $this->name,
            "expr" => $expr,
            "output_fields" => $output_fields,
        ]);

        if (isset($data["status"]["error_code"])) {
            throw new \Exception($data["status"]["reason"], $data["status"]["error_code"]);
        }


        if (isset($data["fields_data"])) {
            $result = [];

            foreach ($data["fields_data"] as $d) {
                $field_name = $d["field_name"];
                if (isset($d["Field"]["Vectors"])) {
                    $dim = $d["Field"]["Vectors"]["dim"];
                    foreach (array_chunk($d["Field"]["Vectors"]["Data"]["FloatVector"]["data"], $dim) as $i => $chunk) {
                        if (!isset($result[$i])) {
                            $result[$i] = [];
                        }

                        $result[$i][$field_name] = $chunk;
                    }
                } elseif (isset($d["Field"]["Scalars"])) {
                    if (isset($d["Field"]["Scalars"]["Data"]["LongData"]["data"])) {
                        foreach ($d["Field"]["Scalars"]["Data"]["LongData"]["data"] as $i => $value) {
                            if (!isset($result[$i])) {
                                $result[$i] = [];
                            }

                            $result[$i][$field_name] = $value;
                        }
                    }
                }
            }
            return $result;
        }

        return $data;
    }

    public function search(array $vector, string $anns_field, int $topk = 10, string $metric_type = "L2", int $nprobe = 10, int $round_decimal = -1, array $output_fields = [], string $expr = null)
    {
        $result = $this->client->search([
            "collection_name" => $this->name,
            "output_fields" => $output_fields,
            "vectors" => [$vector],
            "vector_type" => DataType::FloatVector,
            "search_params" => [
                ["key" => "anns_field", "value" => $anns_field],
                ["key" => "topk", "value" => (string)$topk],
                ["key" => "params", "value" => json_encode(["nprobe" => $nprobe])],
                ["key" => "metric_type", "value" => $metric_type],
                //                ["key" => "round_decimal", "value" => (string)$round_decimal]
            ],
            "dsl_type" => 1,
            "dsl" => $expr
        ]);

        if ($result["status"]["error_code"] ?? false) {
            throw new Exception($result["status"]["reason"], $result["status"]["error_code"]);
        }

        if (isset($result["results"])) {
            $result = $result["results"];
        }


        $data = [];
        foreach ($result["topks"] as $q => $topk) {

            foreach (range(0, $topk - 1) as $i) {
                $d = [];
                $d["score"] = $result["scores"][$i];
                $d["id"] = $result["ids"]["IdField"]["IntId"]["data"][$i];

                foreach ($result["fields_data"] ?? [] as $field_data) {

                    if ($field_data["Field"]["Scalars"]["Data"]) {
                        //get file first array key
                        $key = array_key_first($field_data["Field"]["Scalars"]["Data"]);
                        $d["fields_data"][$field_data["field_name"]] = $field_data["Field"]["Scalars"]["Data"][$key]["data"][$i];
                    }
                }

                $data[] = $d;
            }
        }

        return $data;
    }

    public function getFields()
    {
        $data = $this->client->describeCollection([
            "collection_name" => $this->name
        ]);

        $fields = [];

        foreach ($data["schema"]["fields"] as $field) {
            $fields[] = Field::FromArray($field);
        }

        return $fields;
    }

    public function addField(Field $field)
    {
        $data = $this->client->describeCollection([
            "collection_name" => $this->name
        ]);
        $schema = $data["schema"];

        $schema["fields"][] = $field->toArray();

        //drop collection
        $this->drop();

        //create collection
        $this->client->createCollection($this->name, $schema);
    }

    public function deleteField(string $name)
    {
        $data = $this->client->describeCollection([
            "collection_name" => $this->name
        ]);
        $schema = $data["schema"];

        $schema["fields"] = array_filter($schema["fields"], function ($field) use ($name) {
            return $field["name"] != $name;
        });

        //drop collection
        $this->drop();

        //create collection
        $this->client->createCollection($this->name, $schema);
    }

    public function createIndex(string $field, string $index_type, string $metric_type, array $params)
    {
        return $this->client->createIndex([
            "collection_name" => $this->name,
            "field_name" => $field,
            "extra_params" => [
                ["key" => "metric_type", "value" => $metric_type],
                ["key" => "index_type", "value" => $index_type],
                ["key" => "params", "value" => json_encode($params)]
            ]
        ]);
    } */
}
