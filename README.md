# milvus-client-php

A PHP client for [Milvus](https://milvus.io/) 2.5.x.

## Installation

```bash
composer require mathsgod/milvus-client-php
```

## Quick Start

### Initialize Client

```php
use Milvus\Client;

$client = new Client(
    "http://localhost:19530", // Milvus server URI
    "username",               // Optional: username
    "password",               // Optional: password
    "default",                // Optional: database name
    "token"                   // Optional: JWT token
);
```

---

## Example: Create Collection with Various Field Types and Search

```php
$client = new Milvus\Client();

$client->createCollection(
    collection_name: "testing",
    schema: $client->createSchema()
        ->addField("id", Milvus\DataType::INT64, is_primary: true)
        ->addField("array", Milvus\DataType::ARRAY, element_type: Milvus\DataType::INT64, max_capacity: 10)
        ->addField("vector", Milvus\DataType::FLOAT_VECTOR, dim: 5)
        ->addField("text", Milvus\DataType::VARCHAR, max_length: 1000, nullable: true)
        ->addField("metadata", Milvus\DataType::JSON, nullable: true),
    index_params: $client->prepareIndexParams()
        ->addIndex(
            field_name: "vector",
            index_name: "my_index",
            index_type: Milvus\IndexType::AUTOINDEX,
            metric_type: Milvus\MetricType::COSINE
        ),
);

// Insert data
$client->insert(
    collection_name: "testing",
    data: [
        [
            "id" => 1,
            "array" => [1, 2, 3],
            "vector" => [0.1, 0.2, 0.3, 0.4, 0.5],
            "text" => "Hello World",
            "metadata" => ["key1" => "value1", "key2" => "value2"]
        ],
        [
            "id" => 2,
            "array" => [4, 5, 6],
            "vector" => [0.6, 0.7, 0.8, 0.9, 1.0],
            "text" => null,
            "metadata" => null
        ]
    ]
);

print_R($client->search(
    collection_name: "testing",
    data: [[0.1, 0.2, 0.3, 0.4, 0.5]],
    anns_field: "vector",
    limit: 3,
    output_fields: ["id", "vector", "text", "metadata"],
));
```

#### Example Search Result

```php
Array
(
    [0] => Array
        (
            [distance] => 0.99999994
            [id] => 1
            [metadata] => {"key1":"value1","key2":"value2"}
            [text] => Hello World
            [vector] => Array
                (
                    [0] => 0.1
                    [1] => 0.2
                    [2] => 0.3
                    [3] => 0.4
                    [4] => 0.5
                )

        )

    [1] => Array
        (
            [distance] => 0.96495044
            [id] => 2
            [metadata] =>
            [text] =>
            [vector] => Array
                (
                    [0] => 0.6
                    [1] => 0.7
                    [2] => 0.8
                    [3] => 0.9
                    [4] => 1
                )

        )

)
```

---

## Full-Text Search Example

```php
$client = new Milvus\Client();

$client->dropCollection("testing2");

// Full-Text Search

$client->createCollection(
    collection_name: "testing2",
    schema: $client->createSchema()
        ->addField("id", Milvus\DataType::INT64, is_primary: true)
        ->addField("text_sparse", Milvus\DataType::SPARSE_FLOAT_VECTOR)
        ->addField("document", Milvus\DataType::VARCHAR, max_length: 1000, enable_analyzer: true, enable_match: true)
        ->addFunction(
            name: "bm25",
            function_type: Milvus\FunctionType::BM25,
            input_field_names: ["document"],
            output_field_names: ["text_sparse"]
        ),
    index_params: $client->prepareIndexParams()
        ->addIndex(
            field_name: "text_sparse",
            index_name: "text_sparse_index",
            index_type: Milvus\IndexType::SPARSE_INVERTED_INDEX,
            metric_type: Milvus\MetricType::BM25
        ),
);

// Insert data
$client->insert(
    collection_name: "testing2",
    data: [
        [
            "id" => 1,
            "document" => "This is a sample document for testing.",
        ],
        [
            "id" => 2,
            "document" => "Another document for testing purposes.",
        ],
        [
            "id" => 3,
            "document" => "Milvus is a vector database designed for scalable similarity search.",
        ],
        [
            "id" => 4,
            "document" => "Full-text search enables users to find relevant documents quickly.",
        ],
        [
            "id" => 5,
            "document" => "This document contains information about PHP and Milvus integration.",
        ],
        [
            "id" => 6,
            "document" => "Testing the search functionality with various sample documents.",
        ],
        [
            "id" => 7,
            "document" => "Another example document to increase the dataset size.",
        ],
        [
            "id" => 8,
            "document" => "Sample data helps in validating the search and indexing features.",
        ]
    ]
);

print_r($client->search(
    collection_name: "testing2",
    data: ['sample'],
    anns_field: "text_sparse",
    limit: 5
));
```

---

## Hybrid Search Example

```php
$client = new Milvus\Client();

$client->dropCollection("testing");

// Hybrid Search
$client->createCollection(
    collection_name: "testing",
    schema: $client->createSchema()
        ->addField("id", Milvus\DataType::INT64, is_primary: true)
        ->addField("vector", Milvus\DataType::FLOAT_VECTOR, dim: 5)
        ->addField("document", Milvus\DataType::VARCHAR, max_length: 1000, enable_analyzer: true, enable_match: true)
        ->addField("text_sparse", Milvus\DataType::SPARSE_FLOAT_VECTOR)
        ->addFunction(
            name: "bm25",
            function_type: Milvus\FunctionType::BM25,
            input_field_names: ["document"],
            output_field_names: ["text_sparse"]
        ),
    index_params: $client->prepareIndexParams()
        ->addIndex(
            field_name: "vector",
            index_name: "my_index",
            index_type: Milvus\IndexType::AUTOINDEX,
            metric_type: Milvus\MetricType::COSINE
        )->addIndex(
            field_name: "text_sparse",
            index_name: "text_sparse_index",
            index_type: Milvus\IndexType::SPARSE_INVERTED_INDEX,
            metric_type: Milvus\MetricType::BM25
        ),
);

// Insert data
$client->insert(
    collection_name: "testing",
    data: [
        [
            "id" => 1,
            "vector" => [0.1, 0.2, 0.3, 0.4, 0.5],
            "document" => "This is a sample document for testing.",
        ],
        [
            "id" => 2,
            "vector" => [0.6, 0.7, 0.8, 0.9, 1.0],
            "document" => "Another document for testing purposes.",
        ],
        [
            "id" => 3,
            "vector" => [0.1, 0.2, 0.3, 0.4, 0.5],
            "document" => "Milvus is a vector database designed for scalable similarity search.",
        ],
        [
            "id" => 4,
            "vector" => [0.6, 0.7, 0.8, 0.9, 1.0],
            "document" => "Full-text search enables users to find relevant documents quickly.",
        ],
    ]
);

$query = "sample document";

print_r($client->hybridSearch(
    collection_name: "testing",
    reqs: [
        new HybridSearchRequest(
            data: [[0.1, 0.2, 0.3, 0.4, 0.5]], // embedding vector of the query
            anns_field: "vector",
            limit: 10,
            param: ["nprobe" => 10] // search parameters
        ),
        new HybridSearchRequest(
            data: [$query], // query string
            anns_field: "text_sparse",
            limit: 10,
            param: ["drop_ratio_search" => 0.2]
        )
    ],
    ranker: new WeightedRanker([0.5, 0.5]),
    output_fields: ["id", "document"]
));
```

---

## Database Operations

### Create Database

```php
$client->createDatabase("my_db");
```

### Switch Database

```php
$client->usingDatabase("my_db");
```

### List All Databases

```php
$dbs = $client->listDatabases();
```

### Describe Database

```php
$info = $client->describeDatabase("my_db");
```

### Drop Database

```php
$client->dropDatabase("my_db");
```

---

## Collection Operations

### Create Collection

```php
$client->createCollection(
    collection_name: "test_collection",
    schema: $client->createSchema()
        ->addField("id", Milvus\DataType::INT64, is_primary: true)
        ->addField("array", Milvus\DataType::ARRAY, element_type: Milvus\DataType::INT64, max_capacity: 10)
        ->addField("vector", Milvus\DataType::FLOAT_VECTOR, dim: 5)
        ->addField("text", Milvus\DataType::VARCHAR, max_length: 1000, nullable: true)
        ->addField("metadata", Milvus\DataType::JSON, nullable: true),
    index_params: $client->prepareIndexParams()
        ->addIndex(
            field_name: "vector",
            index_name: "my_index",
            index_type: Milvus\IndexType::AUTOINDEX,
            metric_type: Milvus\MetricType::COSINE
        ),
);
```

### List All Collections

```php
$collections = $client->listCollections();
```

### Describe Collection

```php
$desc = $client->describeCollection("test_collection");
```

### Drop Collection

```php
$client->dropCollection("test_collection");
```

### Load/Release Collection

```php
$client->loadCollection("test_collection");
$client->releaseCollection("test_collection");
```

### Rename Collection

```php
$client->renameCollection("old_name", "new_name");
```

---

## Vector Data Operations

### Insert Data

```php
$entities = [
    ["id" => 1, "vector" => [1.0, 2.0, 3.0, 4.0, 5.0]],
    ["id" => 2, "vector" => [2.0, 2.0, 3.0, 4.0, 5.0]],
];
$client->insert("test_collection", $entities);
```

### Upsert Data

```php
$client->upsert("test_collection", $entities);
```

### Query Data

```php
$result = $client->query("test_collection", "id in [1,2]");
```

### Delete Data

```php
$client->delete("test_collection", "id in [1]");
```

### Vector Search

```php
$result = $client->search(
    collection_name: "test_collection",
    data: [[1.0, 2.0, 3.0, 4.0, 5.0]],
    anns_field: "vector",
    limit: 10,
    output_fields: ["id", "vector"]
); 
```

---

## Index Operations

### Create Index

```php
$indexParams = $client->prepareIndexParams();
$indexParams->addIndex(
    field_name: "vector",
    index_name: "my_index",
    index_type: Milvus\IndexType::AUTOINDEX,
    metric_type: Milvus\MetricType::COSINE
);
$client->createIndex("test_collection", $indexParams);
```

### List Indexes

```php
$indexes = $client->listIndexes("test_collection");
```

---

## Users & Privileges

### List Users

```php
$users = $client->listUsers();
```

### Create User

```php
$client->createUser("test_user", "password");
```

### Describe User

```php
$userInfo = $client->describeUser("test_user");
```

### Drop User

```php
$client->dropUser("test_user");
```

### Update Password

```php
$client->updatePassword("test_user", "old_password", "new_password");
```

---

## Roles & Privileges

### List Roles

```php
$roles = $client->listRoles();
```

### Create Role

```php
$client->createRole("admin");
```

### Describe Role

```php
$roleInfo = $client->describeRole("admin");
```

### Drop Role

```php
$client->dropRole("admin");
```

### Grant Privilege to Role

```php
$client->grantPrivilege("admin", "Collection", "Insert", "test_collection");
```

---

## Advanced

### Hybrid Search

```php
$result = $client->hybridSearch(
    collection_name: "test_collection",
    reqs: [
        new HybridSearchRequest(
            data: [[0.1, 0.2, 0.3, 0.4, 0.5]],
            anns_field: "vector",
            limit: 10,
            param: []
        ),
    ],
    ranker: new Milvus\RRFRanker(10),
    output_fields: ["id", "vector"]
);
```

---

## Reference

- [Milvus Documentation](https://milvus.io/docs)
- [mathsgod/milvus-client-php on GitHub](https://github.com/mathsgod/milvus-client-php)

