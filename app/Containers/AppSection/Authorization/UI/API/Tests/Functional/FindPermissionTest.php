<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;

/**
 * Class FindPermissionTest.
 *
 * @group authorization
 * @group api
 */
class FindPermissionTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/permissions/{id}';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testFindPermissionById(): void
    {
        /** @var Permission $permissionA */
        $permissionA = Permission::factory()->create();

        $response = $this->injectId($permissionA->getKey())->makeCall();

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($permissionA->name, $responseContent->data->name);
    }
}
