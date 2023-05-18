<?php

use Milvus\DataType;
use Milvus\Field;
use Milvus\Schema;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testHealth(): void
    {
        $client = new Milvus\Client();
        $this->assertEquals("ok", $client->health()["status"]);
    }

   
}
