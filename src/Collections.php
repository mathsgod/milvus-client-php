<?php

namespace Milvus;

use Exception;

class Collections
{
    private $client;
    public $dbName = "default";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function alterFieldProperties(
        string $collectionName,
        string $fieldName,
        array $fieldParams
    ) {
        return $this->client->post("/v2/vectordb/collections/fields/alter_properties", [
            "json" => [
                "collectionName" => $collectionName,
                "fieldName" => $fieldName,
                "fieldParams" => $fieldParams,
            ],
        ]);
    }

    /**
     * Alter collection properties.
     * Example for properties:
     * [
     *     CollectionProperty::MMAP_ENABLED => true,
     *     CollectionProperty::COLLECTION_TTL_SECONDS => 60,
     *     CollectionProperty::PARTITIONKEY_ISOLATION => true,
     * ]
     * You can set any supported property key-value pairs here.
     *
     * @param string $collectionName
     * @param array $properties Associative array of property keys and values.
     * @see \Milvus\CollectionProperty
     */
    public function alterProperties(string $collectionName, array $properties)
    {
        return $this->client->post("/v2/vectordb/collections/alter_properties", [
            "json" => [
                "collectionName" => $collectionName,
                "properties" => $properties
            ],
        ]);
    }

    /**
     * This operation compacts the collection by merging small segments into larger ones. It is recommended to call this operation after inserting a large amount of data into a collection.
     */
    public function compact(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/compact", [
            "json" => [
                "collectionName" => $collectionName
            ],
        ]);
    }

    public function create(
        string $collectionName,
        ?int $dimension = null,
        ?string $metricType = null,
        ?string $idType = null,
        ?string $primaryFieldName = "id",
        ?string $vectorFieldName = "vector",
        ?bool $autoID = false,
        ?CollectionSchema $schema = null,
        ?IndexParams $indexParams = null,
        ?bool $enableDynamicField = false
    ) {
        $data = ["collectionName" => $collectionName];
        $data['schema'] = $schema;
        $data['indexParams'] = $indexParams;
        $data['enable_dynamic_field'] = $enableDynamicField;
        $data['dimension'] = $dimension;
        $data['primaryFieldName'] = $primaryFieldName;
        $data['vectorFieldName'] = $vectorFieldName;
        $data['metricType'] = $metricType;
        $data['idType'] = $idType;
        $data['autoID'] = $autoID;

        

        
        return $this->client->post("/v2/vectordb/collections/create", [
            "json" => array_filter($data, fn($value) => $value !== null)
        ]);
    }

    public function describe(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/describe", [
            "json" => [
                "collectionName" => $collectionName,
                "dbName" => $this->dbName
            ],
        ]);
    }

    /**
     * This operation drops the current collection and all data within the collection.
     */
    public function drop(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/drop", [
            "json" => [
                "collectionName" => $collectionName,
                "dbName" => $this->dbName
            ],
        ]);
    }

    /**
     * This operation drops the properties of a collection.
     */
    public function dropProperties(string $collectionName, array $propertyKeys)
    {
        return $this->client->post("/v2/vectordb/collections/drop_properties", [
            "json" => [
                "collectionName" => $collectionName,
                "propertyKeys" => $propertyKeys
            ],
        ]);
    }

    /**
     * This operation flushes the streaming data and seals segments. It is recommended to call this operation after all the data has been inserted into a collection.
     */
    public function flush(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/flush", [
            "json" => [
                "collectionName" => $collectionName
            ],
        ]);
    }

    /**
     * This operation returns the load status of a specific collection.
     */
    public function getLoadState(string $collectionName, ?string $partitionNames = null)
    {
        return $this->client->post("/v2/vectordb/collections/getLoadState", [
            "json" => [
                "collection_name" => $collectionName,
                "partition_names" => $partitionNames,
            ],
        ]);
    }

    public function getStats(string $collectionName)
    {
        return $this->client->post('/v2/vectordb/collections/get_stats', [
            'json' => [
                'collectionName' => $collectionName,
                'dbName' => $this->dbName
            ]
        ]);
    }

    public function has(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/has", [
            "json" => [
                "collectionName" => $collectionName,
                "dbName" => $this->dbName
            ],
        ]);
    }

    public function list()
    {
        return $this->client->post("/v2/vectordb/collections/list", [
            "json" => [
                "dbName" => $this->dbName
            ],
        ]);
    }

    public function load(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/load", [
            "json" => [
                "collectionName" => $collectionName
            ],
        ]);
    }

    public function release(string $collectionName)
    {
        return $this->client->post('/v2/vectordb/collections/release', [
            'json' => [
                'collectionName' => $collectionName,
                'dbName' => $this->dbName
            ]
        ]);
    }

    public function rename(string $oldName, string $newName)
    {
        return $this->client->post("/v2/vectordb/collections/rename", [
            "json" => [
                "collectionName" => $oldName,
                "newCollectionName" => $newName
            ],
        ]);
    }

    /**
     * This operaton refreshes the load of a collection.
     */
    public function refreshLoad(string $collectionName)
    {
        return $this->client->post("/v2/vectordb/collections/refresh_load", [
            "json" => [
                "collectionName" => $collectionName
            ],
        ]);
    }
}
