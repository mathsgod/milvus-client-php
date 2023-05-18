# milvus-client-php

## Setup

```
composer require mathsgod/milvus-client-php
```


## Usage

### Create a Collection
```php
$client=new Milvus\Client($host, $port);

$schema = new Schema();
$schema->addField("book_id", DataType::Int64,true);
$schema->addField(new Field("book_intro", DataType::FloatVector, false, 2));//dimension 2
$client->createCollection("book",$schema);
```


### Create Index
```php
$collection = $client->getCollection("book");
$collection->createIndex("book_intro", IndexType::IVF_FLAT, MetricType::L2, IVF_FLAT::Param(128));
```

### Insert Vectors
```php
$collection = $client->getCollection("book");
$collection->insert([
    [
        "book_id" => 1,
        "book_intro" => [1.0, 2.0]
    ],
    [
        "book_id" => 2,
        "book_intro" => [1.0, 2.0]
    ],
    [
        "book_id" => 3,
        "book_intro" => [1.0, 2.0]
    ],
    [
        "book_id" => 4,
        "book_intro" => [1.0, 2.0]
    ],
    [
        "book_id" => 5,
        "book_intro" => [1.0, 2.0]
    ],
]);
```

### Load Collection
```php
$collection = $client->getCollection("book");
$collection->load();
```

### Search Vectors
```php
$collection = $client->getCollection("book");
$result = $client->getCollection("test_collection")->search([1.0, 0.1], "book_intro", 10); //topk=10
```

### Query Entities
```php
$collection = $client->getCollection("book");
$result = $collection->query("book_id in [1,2,3,4,5]");
```

### Delete Entities
```php
$collection = $client->getCollection("book");
$collection->deleteEntities("book_id in [1]");
```


