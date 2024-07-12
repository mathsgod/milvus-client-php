# milvus-client-php

## Setup

```
composer require mathsgod/milvus-client-php
```


## Usage

### Create a Collection
```php
$client=new Milvus\Client($host, $port);

// Create a collection with 5 dimensions
$client->collections()->create("test_collection",5);

```

### Insert Vectors
```php
$collection = $client->entities("test_collection");
$collection->insert([
    [ "id"=>1, "vector" => [1.0, 2.0, 3.0, 4.0, 5.0] ],
    [ "id"=>2, "vector" => [2.0, 2.0, 3.0, 4.0, 5.0] ],
    [ "id"=>3, "vector" => [3.0, 2.0, 3.0, 4.0, 5.0] ],
    [ "id"=>4, "vector" => [4.0, 2.0, 3.0, 4.0, 5.0] ],
    [ "id"=>5, "vector" => [5.0, 2.0, 3.0, 4.0, 5.0] ],
]);
```

### Load Collection
```php
$collection = $client->collection("test_collection");
$collection->load();
```

### Search Vectors
```php
// Search for the top 10 vectors that are most similar to the vector [1.0,3.0,3.0,4.0,5.0]
$result = $client->entities("test_collection")->search("vector",[1.0,3.0,3.0,4.0,5.0],10);
```

### Query Entities
```php
$e = $client->entities("test_collection");
$result = $e->query("id in [1,2,3,4,5]");
```

### Delete Entities
```php
$e = $client->entities("test_collection");
$e->delete("id in [1]");
```


## Users

### List Users
```php
$users = $client->users()->list();
```

### Create a User
```php
$client->users()->create("test_user");
```

### Delete a User
```php
$client->user("test_user")->drop();
```

### Grant role
```php
$client->user("test_user")->grantRole("admin");
```

### Revoke role
```php
$client->user("test_user")->revokeRole("admin");
```

## Roles

### List roles
```php
$roles = $client->roles()->list();
```

