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
}
