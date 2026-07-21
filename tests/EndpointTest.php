<?php

use Milvus\Client;
use Milvus\Http\Collections;
use Milvus\Http\Indexes;
use Milvus\Http\PrivilegeGroups;
use Milvus\Http\Roles;
use PHPUnit\Framework\TestCase;

class EndpointTest extends TestCase
{
    public function testMissingCollectionEndpointsUseOfficialPaths(): void
    {
        $cases = [
            ['addFunction', '/v2/vectordb/collections/add_function'],
            ['alterFunction', '/v2/vectordb/collections/alter_function'],
            ['describeExternalRefreshJob', '/v2/vectordb/jobs/external_collection/describe'],
            ['dropFunction', '/v2/vectordb/collections/drop_function'],
            ['getCompactionState', '/v2/vectordb/collections/get_compaction_state'],
            ['listExternalRefreshJobs', '/v2/vectordb/jobs/external_collection/list'],
            ['refreshExternal', '/v2/vectordb/jobs/external_collection/refresh'],
            ['runAnalyzer', '/v2/vectordb/common/run_analyzer'],
            ['truncate', '/v2/vectordb/collections/truncate'],
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

    public function testPrivilegeGroupEndpointsUseOfficialPaths(): void
    {
        $cases = [
            ['create', '/v2/vectordb/privilege_groups/create'],
            ['drop', '/v2/vectordb/privilege_groups/drop'],
            ['list', '/v2/vectordb/privilege_groups/list'],
            ['addPrivileges', '/v2/vectordb/privilege_groups/add_privileges_to_group'],
            ['removePrivileges', '/v2/vectordb/privilege_groups/remove_privileges_from_group'],
        ];

        $calls = $this->mockPostCalls(count($cases));
        $http = new PrivilegeGroups($calls['client']);

        foreach ($cases as [$method, $path]) {
            $params = ['privilegeGroupName' => 'test_group'];
            $this->assertSame([], $http->{$method}($params));
        }

        $this->assertSame(
            array_map(fn ($case) => $case[1], $cases),
            array_column($calls['calls'], 'uri')
        );
    }

    public function testMissingRoleEndpointsUseOfficialPaths(): void
    {
        $cases = [
            ['alter', '/v2/vectordb/roles/alter'],
            ['grantPrivilegeV2', '/v2/vectordb/roles/grant_privilege_v2'],
            ['revokePrivilegeV2', '/v2/vectordb/roles/revoke_privilege_v2'],
        ];

        $calls = $this->mockPostCalls(count($cases));
        $http = new Roles($calls['client']);

        foreach ($cases as [$method, $path]) {
            $params = ['roleName' => 'test_role'];
            $this->assertSame([], $http->{$method}($params));
        }

        $this->assertSame(
            array_map(fn ($case) => $case[1], $cases),
            array_column($calls['calls'], 'uri')
        );
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
