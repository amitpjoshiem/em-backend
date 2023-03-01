<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;

/**
 * Class DeleteRoleTest.
 *
 * @group authorization
 * @group api
 */
class DeleteRoleTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/roles/{id}';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testDeleteExistingRole(): void
    {
        /** @var Role $role */
        $role = Role::factory()->create();

        $response = $this->injectId($role->getKey())->makeCall();

        $response->assertStatus(204);
    }
}
