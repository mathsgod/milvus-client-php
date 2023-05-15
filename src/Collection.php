<?php

namespace Milvus;

class Collection
{
    private $client;
    private $name;
    public function __construct(Client $client, string $name)
    {
        $this->client = $client;
        $this->name = $name;
    }

    public function deleteEntities(string $expr)
    {
        return $this->client->deleteEntities([
            "collection_name" => $this->name,
            "expr" => $expr
        ]);
    }

    public function dropIndex()
    {
        $this->client->dropIndex([
            "collection_name" => $this->name,
        ]);
    }

    public function insert(array $data)
    {
        $this->client->insert([
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
        $this->client->releaseCollection([
            "collection_name" => $this->name
        ]);
    }

    public function load()
    {
        $this->client->loadCollection([
            "collection_name" => $this->name
        ]);
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

    public function search(array $vectors, string $anns_field, int $topk, string $metric_type, int $nprobe, int $round_decimal = -1)
    {
        return $this->client->search([
            "collection_name" => $this->name,
            "vectors" => $vectors,
            "vector_type" => DataType::FloatVector,
            "search_params" => [
                ["key" => "anns_field", "value" => $anns_field],
                ["key" => "topk", "value" => (string)$topk],
                ["key" => "params", "value" => json_encode(["nprobe" => $nprobe])],
                ["key" => "metric_type", "value" => $metric_type],
                //                ["key" => "round_decimal", "value" => (string)$round_decimal]
            ],
            "dsl_type" => 1
        ]);
    }

    public function getFields()
    {
        $data = $this->client->describeCollection([
            "collection_name" => $this->name
        ]);

        $fields = [];

        foreach ($data["schema"]["fields"] as $field) {
            $f = new Field($this->client, $field["name"]);
            //build field
            foreach ($field as $key => $value) {
                $f->$key = $value;
            }

            $fields[] = $f;
        }

        return $fields;
    }

    public function createIndex(string $field, string $metric_type, string $index_type, array $params)
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
    }
}
