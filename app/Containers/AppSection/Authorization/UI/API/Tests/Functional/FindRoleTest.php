<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;

/**
 * Class FindRoleTest.
 *
 * @group authorization
 * @group api
 */
class FindRoleTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/roles/{id}';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testFindRoleById(): void
    {
        /** @var Role $roleA */
        $roleA = Role::factory()->create();

        $response = $this->injectId($roleA->getKey())->makeCall();

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($roleA->name, $responseContent->data->name);
    }
}
