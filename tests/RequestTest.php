<?php

use Milvus\Client;
use Milvus\DataType;
use Milvus\IndexType;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testV30VectorPayloadsIncludeVersionSpecificFields(): void
    {
        $calls = [];
        $client = $this->mockClient($calls, 6);

        $client->insert('items', [['id' => 1]], 'p1', true);
        $client->get('items', [1], ['id'], ['p1'], 'Strong', 'p1');
        $client->delete('items', null, null, 'p1', 'id-1', ['value' => 1]);
        $client->query('items', 'id == $id', expr_params: ['id' => 1], consistency_level: 'Strong');
        $client->search(
            collection_name: 'items',
            data: [],
            ids: [1],
            offset: 2,
            grouping_field: 'category',
            group_size: 3,
            strict_group_size: true,
            expr_params: ['value' => 1],
            function_score: ['name' => 'score']
        );
        $client->hybridSearch(
            collection_name: 'items',
            search: [],
            ranker: [],
            partition_name: 'p1',
            offset: 2,
            group_size: 3,
            strict_group_size: true,
            expr_params: ['value' => 1],
            function_score: ['name' => 'score']
        );

        $this->assertTrue($calls[0]['options']['json']['partialUpdate']);
        $this->assertSame('p1', $calls[1]['options']['json']['partitionName']);
        $this->assertSame('id-1', $calls[2]['options']['json']['id']);
        $this->assertSame(['id' => 1], $calls[3]['options']['json']['exprParams']);
        $this->assertArrayNotHasKey('data', $calls[4]['options']['json']);
        $this->assertSame([1], $calls[4]['options']['json']['ids']);
        $this->assertSame(['p1'], $calls[5]['options']['json']['partitionNames']);
        $this->assertSame(3, $calls[5]['options']['json']['groupSize']);
    }

    public function testImportPayloadSupportsVolumeData(): void
    {
        $calls = [];
        $client = $this->mockClient($calls, 2);

        $client->createImportJob(
            'items',
            volume_name: 'volume-1',
            data_paths: [['data/items.json']]
        );
        $client->listImportJobs();

        $this->assertSame('default', $calls[0]['options']['json']['dbName']);
        $this->assertSame('volume-1', $calls[0]['options']['json']['volumeName']);
        $this->assertSame([['data/items.json']], $calls[0]['options']['json']['dataPaths']);
        $this->assertSame('/v2/vectordb/jobs/import/list', $calls[1]['uri']);
    }

    public function testSupportedConstantsAndVectorDimensionValidation(): void
    {
        $this->assertSame('GPU_CAGRA', IndexType::GPU_CAGRA);
        $this->assertSame('GPU_CAGRA', IndexType::GPU_CAGRAPH);
        $this->assertSame('Text', DataType::TEXT);

        $schema = new Milvus\CollectionSchema();
        $schema->addField('vector', DataType::FLOAT16_VECTOR, dim: 8);

        $this->expectException(InvalidArgumentException::class);
        $schema->addField('missing_dim', DataType::BINARY_VECTOR);
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
