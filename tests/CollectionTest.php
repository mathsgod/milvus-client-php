<?php

use PHPUnit\Framework\TestCase;
use Milvus\Client;
use Milvus\DataType;

class CollectionTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $this->client = new Client();
    }

    public function testCreateAndDropCollection()
    {
        $collectionName = 'phpunit_test_collection_' . uniqid();

        // 建立 collection
        $schema = $this->client->createSchema();
        $schema->addField("id", DataType::INT64, true); // 主鍵
        $schema->addField(
            field_name: "vector",
            datatype: DataType::FLOAT_VECTOR,
            dim: 128
        ); // 向量欄位，假設維度為128

        $this->client->createCollection(
            collection_name: $collectionName,
            schema: $schema
        );

        // 應該能在列表中找到
        $collections = $this->client->listCollections();
        $this->assertContains($collectionName, $collections);

        $this->client->dropCollection($collectionName);

        // 應該找不到該 collection
        $collectionsAfter = $this->client->listCollections();
        $this->assertNotContains($collectionName, $collectionsAfter);
    }

    public function testListCollection()
    {
        $collections = $this->client->listCollections();
        $this->assertIsArray($collections);
        // 檢查每個 collection 名稱都是字串
        foreach ($collections as $name) {
            $this->assertIsString($name);
        }
    }

    public function testDescribeCollection()
    {
        $collectionName = 'phpunit_test_describe_' . uniqid();

        // 建立 collection
        $schema = $this->client->createSchema();
        $schema->addField("id", DataType::INT64, true);
        $schema->addField(
            field_name: "vector",
            datatype: DataType::FLOAT_VECTOR,
            dim: 16
        );
        $this->client->createCollection(
            collection_name: $collectionName,
            schema: $schema
        );

        // describe collection
        $desc = $this->client->describeCollection($collectionName);
        $this->assertIsArray($desc);
        $this->assertArrayHasKey('fields', $desc);
        $this->assertIsArray($desc['fields']);
        $this->assertNotEmpty($desc['fields']);

        // 清理
        $this->client->dropCollection($collectionName);
    }

    public function testRenameCollection()
    {
        $originalName = 'phpunit_test_rename_' . uniqid();
        $newName = $originalName . '_renamed';

        // 建立 collection
        $schema = $this->client->createSchema();
        $schema->addField("id", DataType::INT64, true);
        $schema->addField(
            field_name: "vector",
            datatype: DataType::FLOAT_VECTOR,
            dim: 8
        );
        $this->client->createCollection(
            collection_name: $originalName,
            schema: $schema
        );

        // 執行 rename
        $this->client->collections()->rename($originalName, $newName);

        // 新名稱應存在，舊名稱應不存在
        $collections = $this->client->listCollections();
        $this->assertContains($newName, $collections);
        $this->assertNotContains($originalName, $collections);

        // 清理
        $this->client->dropCollection($newName);
    }

}
