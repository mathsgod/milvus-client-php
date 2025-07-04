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
$schema = $client->createSchema();
$schema->add_field("id", Milvus\DataType::INT64, true);
$schema->add_field("vector", Milvus\DataType::FLOAT_VECTOR, false, 5);

$client->createCollection(
    "test_collection",
    5,
    "id",
    "vector",
    "COSINE",
    false,
    null,
    $schema
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
    "test_collection",
    [[1.0, 2.0, 3.0, 4.0, 5.0]],
    "",
    10,
    ["id"]
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
    "test_collection",
    $reqs,      // search conditions
    $ranker,    // ranking rules
    10,         // limit
    ["id", "vector"] // output fields
);
```

---

## Reference

- [Milvus Documentation](https://milvus.io/docs)
- [mathsgod/milvus-client-php on GitHub](https://github.com/mathsgod/milvus-client-php)

