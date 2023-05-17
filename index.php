<?php

use Milvus\Client;
use Milvus\Collection;
use Milvus\DataType;
use Milvus\Schema;
use Milvus\Field;

require_once('./vendor/autoload.php');

$client = new Client();

/* $c = $client->getCollection("embedding");

$c->createIndex("value", "L2", "IVF_FLAT", ["nlist" => 1024]);
 */

/* print_r($c->addField(Field::FromArray([
    "name" => "content",
    "data_type" => DataType::VarChar,
    "type_params" => [
        [
            "key" => "max_length",
            "value" => "65535"
        ]
    ],

])));
die();

 */
//print_r($c->createIndex("value","L2","IVF_FLAT",["nlist"=>1024]));


/* print_r($c->drop());

//print_r($c->query("embedding_id <10000"));
die();



print_R($client->describeCollection([
    "collection_name" => "embedding"
]));
die();
//drop collection
 */

/* 
$schema = new Schema();
$schema->description = "Sjsmile";
$schema->autoID = false;

$schema->addField(Field::FromArray([
    "name" => "embedding_id",
    "data_type" => DataType::Int64,
    "is_primary_key" => true,
    "description" => "embedding id",
]));

$schema->addField(Field::FromArray([
    "name" => "id",
    "data_type" => DataType::Int64,
    "is_primary_key" => false,
]));


$schema->addField(Field::FromArray([
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
]));

$schema->addField(Field::FromArray([
    "name" => "token",
    "data_type" => DataType::Int64,
    "is_primary_key" => false,
]));

$schema->addField(Field::FromArray([
    "name" => "type",
    "data_type" => DataType::VarChar,
    "is_primary_key" => false,
    "type_params" => [
        [
            "key" => "max_length",
            "value" => "65535"
        ]
    ],
]));

$result = $client->createCollection([
    "collection_name" => "embedding",
    "schema" => json_decode(json_encode($schema), true),
]);

print_R($result);
die(); */
/* print_R($client->describeCollection([
    "collection_name" => "embedding"
]));
die();


print_R($client->describeCollection([
    "collection_name" => "book"
]));
die();

$c = new Collection($client, "book");
$c->addField("book_id", DataType::Int64); */


new Collection($client, "embedding");


//use pdo to connect mysql raymond4.hostlink.com.hk, and query the date of Embedding table
$dsn = 'mysql:host=raymond4.hostlink.com.hk;dbname=raymond4;port=3307;charset=utf8mb4';
$pdo = new PDO($dsn, 'raymond4', 'JWjUFhJnV');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//query the data of Embedding table
$sql = "SELECT * FROM Embedding";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$c = new Collection($client, "embedding");

foreach ($stmt as $row) {


    $d = $row;
    $d["value"] = json_decode($row["value"], true);


    $c->insert([$d]);
}

echo "done";
die();






$client = new Client();

$collection = new Collection($client, "book");

print_r($collection->query("book_id in [100]"));
die();

$i = $collection->insert([
    [
        "book_id" => 101,
        "book_intro" => [1, 2, 3]
    ]
]);

print_r($i);





//die();
//print_r($collection->deleteEntities("book_id < 10000"));

die();


//print_R($collection->getFields());
//die();

print_R($collection->query("book_id < 100", ["book_intro"]));

die();

print_R($collection->search([[0.1, 0.2]], "book_intro", 10, "L2", 10));





die();


/* $index = $client->createIndex([
    "collection_name" => "book",
    "field_name" => "book_intro",
    "extra_params" => [
        ["key" => "metric_type", "value" => "L2"],
        ["key" => "index_type", "value" => "IVF_FLAT"],
        ["key" => "params", "value" => json_encode(["nlist" => 128])]
    ]
]);

print_r($index);
die(); */


print_r($client->search([
    "collection_name" => "book",
    "output_fields" => ["book_id"],
    "search_params" => [
        ["key" => "anns_field", "value" => "book_intro"],
        ["key" => "metric_type", "value" => "L2"],
        ["key" => "round_decimal", "value" => "-1"],
        ["key" => "topk", "value" => "2"],
        ["key" => "params", "value" => json_encode(["nprobe" => 10])]
    ],
    "vectors" => [[0.1, 0.2]],
    "dsl_type" => 1
]));
die();



print_r($client->describeCollection([
    "collection_name" => "book"
]));


die();



$data = [];
foreach (range(1, 10) as $i) {
    $data[] = [
        "book_id" => $i,
        "book_intro" => [mt_rand(1, 100), mt_rand(1, 100)]
    ];
}


$client = new Client();

print_r($client->insert([
    "collection_name" => "book",
    "fields_data" => $data
]));


die();

$resp = $client->createCollection([
    'collection_name' => 'book',
    "description" => "this is a book collection",
    "fields" => [
        [
            "name" => "book_intro",
            "data_type" => DataType::FloatVector,
            "dim" => 2
        ],
        [
            "name" => "book_id",
            "is_primary_key" => true,
            "data_type" => DataType::Int64,
        ],
    ]
]);


print_r($resp);
