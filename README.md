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
$schema->description = "book";

$schema->addField([
    "name" => "book_id",
    "data_type" => DataType::Int64,
    "is_primary_key" => true,
    "description" => "book id",
]);

$schema->addField([
    "name" => "value",
    "description" => "embedding vector",
    "data_type" => DataType::FloatVector,
    "is_primary_key" => false,
    "type_params" => [
        [
            "key" => "dim",
            "value" => "1536"
        ]
    ],
]);

$client->createCollection([
    "collection_name" => "book",
    "schema" => $schema
]);

```
