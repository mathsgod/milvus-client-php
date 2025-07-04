<?php

use PHPUnit\Framework\TestCase;
use Milvus\Client;
use Milvus\DataType;

class DataTest extends TestCase
{
    private static $client;
    private static $collectionName;

    public static function setUpBeforeClass(): void
    {
        self::$collectionName = "test_collection_" . uniqid();
        self::$client = new Client();
        // 刪除舊的 collection（如果存在）
        try {
            self::$client->drop_collection(self::$collectionName);
        } catch (\Exception $e) {
            // 忽略不存在的錯誤
        }

        // 建立 schema
        $schema = self::$client->create_schema();
        $schema->add_field(field_name: "id", datatype: DataType::INT64, is_primary: true);
        $schema->add_field(field_name: "vector", datatype: DataType::FLOAT_VECTOR, dim: 2);


        //create index params
        $indexParams = self::$client->prepare_index_params();
        $indexParams->addIndex(field_name: "vector", index_name: "my_index", index_type: Milvus\IndexType::AUTOINDEX, metric_type: Milvus\MetricType::COSINE);


        // 建立 collection
        self::$client->create_collection(
            collection_name: self::$collectionName,
            schema: $schema,
            index_params: $indexParams
        );
    }

    public function getClient(): Client
    {
        return self::$client;
    }

    public function testInsertData()
    {
        $entities = [
            ["id" => 1, "vector" => [0.1, 0.2]],
            ["id" => 2, "vector" => [0.2, 0.3]],
        ];
        $result = self::$client->insert(self::$collectionName, $entities);

        // Assert the insert count is correct
        $this->assertEquals(2, $result['insertCount']);

        // Assert the inserted IDs are as expected
        $this->assertEquals([1, 2], $result['insertIds']);
    }

    public function testSearchData()
    {
        $searchData = [[0.1, 0.2]];
        $result = $this->getClient()->search(
            collection_name: self::$collectionName,
            data: $searchData,
            anns_field: 'vector',
            limit: 1
        );
        // Assert the search result is not empty
        $this->assertNotEmpty($result);
        $this->assertEquals(1, count($result));
    }

    public function testDeleteData()
    {
        $deleteResult = $this->getClient()->delete(self::$collectionName, 'id in [1]');
        $this->assertEquals(1, $deleteResult['deleteCount']);
    }

    public static function tearDownAfterClass(): void
    {
        self::$client->drop_collection(self::$collectionName);
    }
}
