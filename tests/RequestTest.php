<?php

use Milvus\Client;
use Milvus\DataType;
use Milvus\IndexType;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testV26VectorPayloadsIncludeSupportedFields(): void
    {
        $calls = [];
        $client = $this->mockClient($calls, 5);

        $client->insert('items', [['id' => 1]], 'p1');
        $client->get('items', ['id-1'], ['id'], ['p1']);
        $client->delete('items', null, ['id-1', 'id-2'], 'p1');
        $client->search(
            collection_name: 'items',
            data: [[0.1]],
            offset: 2,
            grouping_field: 'category'
        );
        $client->hybridSearch(
            collection_name: 'items',
            search: [],
            ranker: [],
            partition_name: 'p1',
            offset: 2
        );

        $this->assertSame('p1', $calls[0]['options']['json']['partitionName']);
        $this->assertSame(['p1'], $calls[1]['options']['json']['partitionNames']);
        $this->assertSame('id in ["id-1","id-2"]', $calls[2]['options']['json']['filter']);
        $this->assertSame('p1', $calls[2]['options']['json']['partitionName']);
        $this->assertSame(2, $calls[3]['options']['json']['offset']);
        $this->assertSame('category', $calls[3]['options']['json']['groupingField']);
        $this->assertSame(['p1'], $calls[4]['options']['json']['partitionNames']);
    }

    public function testImportPayloadsIncludeDatabaseName(): void
    {
        $calls = [];
        $client = $this->mockClient($calls, 2);

        $client->createImportJob('items', files: [['file.json']]);
        $client->listImportJobs();

        $this->assertSame('default', $calls[0]['options']['json']['dbName']);
        $this->assertSame('default', $calls[1]['options']['json']['dbName']);
        $this->assertSame('/v2/vectordb/jobs/import/create', $calls[0]['uri']);
        $this->assertSame('/v2/vectordb/jobs/import/list', $calls[1]['uri']);
    }

    public function testSupportedConstantsAndVectorDimensionValidation(): void
    {
        $this->assertSame('GPU_CAGRA', IndexType::GPU_CAGRA);
        $this->assertSame('GPU_CAGRA', IndexType::GPU_CAGRAPH);
        $this->assertSame('Float16Vector', DataType::FLOAT16_VECTOR);

        $schema = new Milvus\CollectionSchema();
        $schema->addField('vector', DataType::BINARY_VECTOR, dim: 8);

        $this->expectException(InvalidArgumentException::class);
        $schema->addField('missing_dim', DataType::BFLOAT16_VECTOR);
    }

    private function mockClient(array &$calls, int $expectedCalls): Client
    {
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['post'])
            ->getMock();

        $client->expects($this->exactly($expectedCalls))
            ->method('post')
            ->willReturnCallback(function (string $uri, array $options) use (&$calls): array {
                $calls[] = ['uri' => $uri, 'options' => $options];
                return [];
            });

        return $client;
    }
}
