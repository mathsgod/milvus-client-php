<?php

use Milvus\DataType;
use Milvus\Field;
use Milvus\Index\IVF_FLAT;
use Milvus\IndexType;
use Milvus\MetricType;
use Milvus\Schema;
use PHPUnit\Framework\TestCase;

final class CollectionTest extends TestCase
{
    public function testCreateCollection(): void
    {
        $client = new Milvus\Client();
        //drop collection if exists
        $client->dropCollection("test_collection");


        $schema = new Schema();
        $schema->addField(new Field("book_id", DataType::Int64, true));
        $schema->addField(new Field("book_intro", DataType::FloatVector, false, 2));
        $client->createCollection("test_collection", $schema);

        //check if collection exists
        $collections = $client->showCollections();


        $this->assertContains("test_collection", $collections["collection_names"]);
    }

    public function testInsert()
    {
        $client = new Milvus\Client();
        $client->dropCollection("test_collection");

        $schema = new Schema();
        $schema->addField(new Field("book_id", DataType::Int64, true));
        $schema->addField(new Field("book_intro", DataType::FloatVector, false, 2));
        $client->createCollection("test_collection", $schema);


        //create index

        $collection = $client->getCollection("test_collection");
        $collection->createIndex("book_intro", IndexType::IVF_FLAT, MetricType::L2, IVF_FLAT::Param(128));

        $fields_data = [
            [
                "book_id" => 1,
                "book_intro" => [1.0, 0.1]
            ],
            [
                "book_id" => 2,
                "book_intro" => [1.0, 0.2]
            ],
            [
                "book_id" => 3,
                "book_intro" => [1.0, 0.3]
            ],
            [
                "book_id" => 4,
                "book_intro" => [1.0, 0.4]
            ],
            [
                "book_id" => 5,
                "book_intro" => [1.0, 0.5]
            ],
        ];


        $collection->insert($fields_data);
        $collection->load();

        sleep(3);


        $result = $collection->query("book_id<10");

        $this->assertEquals(5, count($result));
    }

    public function testgetPrimaryKeyField()
    {
        $client = new Milvus\Client();
        $field = $client->getCollection("test_collection")->getPrimaryKeyField();

        $this->assertEquals("book_id", $field->name);
    }

    public function testSearch()
    {
        $client = new Milvus\Client();
        $client->getCollection("test_collection");

        $result = $client->getCollection("test_collection")->search([1.0, 0.1], "book_intro", 10);

        $this->assertEquals(5, count($result));
    }
}
