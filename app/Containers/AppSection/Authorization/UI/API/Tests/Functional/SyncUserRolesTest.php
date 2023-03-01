<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Arr;

/**
 * Class SyncUserRolesTest.
 *
 * @group authorization
 * @group api
 */
class SyncUserRolesTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/roles/sync?include=roles';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ADMINS_ACCESS,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testSyncMultipleRolesOnUser(): void
    {
        /** @var Role $role1 */
        $role1 = Role::factory()->create(['display_name' => '111']);

        /** @var Role $role2 */
        $role2 = Role::factory()->create(['display_name' => '222']);

        /** @var User $randomUser */
        $randomUser = User::factory()->create();

        $randomUser->assignRole($role1);

        $data = [
            'roles_ids' => [
                $role1->getHashedKey(),
                $role2->getHashedKey(),
            ],
            'user_id'   => $randomUser->getHashedKey(),
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertTrue((is_countable($responseContent->data->roles) ? \count($responseContent->data->roles) : 0) > 1);

        $roleIds = Arr::pluck($responseContent->data->roles, 'id');
        self::assertContains($data['roles_ids'][0], $roleIds);

        self::assertContains($data['roles_ids'][1], $roleIds);
    }
}
