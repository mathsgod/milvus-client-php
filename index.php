<?php

use Milvus\Client;
use Milvus\Collection;
use Milvus\DataType;

require_once('./vendor/autoload.php');

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
