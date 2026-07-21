<?php

use Milvus\Client;
use Milvus\Http\Collections;
use Milvus\Http\Indexes;
use PHPUnit\Framework\TestCase;

class EndpointTest extends TestCase
{
    public function testCollectionEndpointsUseV26OfficialPaths(): void
    {
        $cases = [
            ['addField', '/v2/vectordb/collections/fields/add'],
            ['alterFieldProperties', '/v2/vectordb/collections/fields/alter_properties'],
            ['alterProperties', '/v2/vectordb/collections/alter_properties'],
            ['compact', '/v2/vectordb/collections/compact'],
            ['create', '/v2/vectordb/collections/create'],
            ['describe', '/v2/vectordb/collections/describe'],
            ['dropProperties', '/v2/vectordb/collections/drop_properties'],
            ['drop', '/v2/vectordb/collections/drop'],
            ['flush', '/v2/vectordb/collections/flush'],
            ['getLoadState', '/v2/vectordb/collections/get_load_state'],
            ['getStats', '/v2/vectordb/collections/get_stats'],
            ['has', '/v2/vectordb/collections/has'],
            ['list', '/v2/vectordb/collections/list'],
            ['load', '/v2/vectordb/collections/load'],
            ['refreshLoad', '/v2/vectordb/collections/refresh_load'],
            ['release', '/v2/vectordb/collections/release'],
            ['rename', '/v2/vectordb/collections/rename'],
        ];

        $calls = $this->mockPostCalls(count($cases));
        $http = new Collections($calls['client']);

        foreach ($cases as [$method, $path]) {
            $params = ['collectionName' => 'test_collection'];
            $this->assertSame([], $http->{$method}($params));
        }

        $this->assertSame(
            array_map(fn ($case) => $case[1], $cases),
            array_column($calls['calls'], 'uri')
        );
        $this->assertSame(
            array_fill(0, count($cases), ['json' => ['collectionName' => 'test_collection']]),
            array_column($calls['calls'], 'options')
        );
    }

    public function testMissingIndexEndpointUsesOfficialPath(): void
    {
        $calls = $this->mockPostCalls(1);
        $http = new Indexes($calls['client']);
        $params = ['indexName' => 'test_index'];

        $this->assertSame([], $http->alterProperties($params));
        $this->assertSame('/v2/vectordb/indexes/alter_properties', $calls['calls'][0]['uri']);
        $this->assertSame(['json' => $params], $calls['calls'][0]['options']);
    }

    private function mockPostCalls(int $expected_calls): array
    {
        $calls = [];
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['post'])
            ->getMock();

        $client->expects($this->exactly($expected_calls))
            ->method('post')
            ->willReturnCallback(function (string $uri, array $options) use (&$calls): array {
                $calls[] = [
                    'uri' => $uri,
                    'options' => $options,
                ];

                return [];
            });

        return [
            'client' => $client,
            'calls' => &$calls,
        ];
    }
}
