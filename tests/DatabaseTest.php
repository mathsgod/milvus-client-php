<?php

use PHPUnit\Framework\TestCase;


class DatabaseTest extends TestCase
{
    public function testListDatabase()
    {
        // Assuming you have a MilvusClient class with a listDatabase method
        $client = new Milvus\Client();

        $databases = $client->list_databases();

        $this->assertIsArray($databases, 'listDatabase should return an array');
        // Optionally, check for expected database names
        // $this->assertContains('default', $databases);
    }
}
