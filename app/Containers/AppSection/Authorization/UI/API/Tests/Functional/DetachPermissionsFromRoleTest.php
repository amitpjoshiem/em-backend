<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;

/**
 * Class DetachPermissionsFromRoleTest.
 *
 * @group authorization
 * @group api
 */
class DetachPermissionsFromRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/permissions/detach';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testDetachSinglePermissionFromRole(): void
    {
        /** @var Role $roleA */
        $roleA = Role::factory()->create();

        /** @var Permission $permissionA */
        $permissionA = Permission::factory()->create();

        $roleA->givePermissionTo($permissionA);

        $data = [
            'role_id'         => $roleA->getHashedKey(),
            'permissions_ids' => [$permissionA->getHashedKey()],
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($roleA->name, $responseContent->data->name);

        $this->assertDatabaseMissing(config('permission.table_names.role_has_permissions'), [
            $permissionA->getForeignKey() => $permissionA->getKey(),
            $roleA->getForeignKey()       => $roleA->getKey(),
        ]);
    }

    /**
     * @test
     */
    public function testDetachMultiplePermissionFromRole(): void
    {
        /** @var Role $roleA */
        $roleA = Role::factory()->create();

        /** @var Permission $permissionA */
        $permissionA = Permission::factory()->create();

        /** @var Permission $permissionB */
        $permissionB = Permission::factory()->create();

        $roleA->givePermissionTo($permissionA);
        $roleA->givePermissionTo($permissionB);

        $data = [
            'role_id'         => $roleA->getHashedKey(),
            'permissions_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($roleA->name, $responseContent->data->name);

        $this->assertDatabaseMissing(config('permission.table_names.role_has_permissions'), [
            $permissionA->getForeignKey() => $permissionA->getKey(),
            $roleA->getForeignKey()       => $roleA->getKey(),
        ]);

        $this->assertDatabaseMissing(config('permission.table_names.role_has_permissions'), [
            $permissionB->getForeignKey() => $permissionB->getKey(),
            $roleA->getForeignKey()       => $roleA->getKey(),
        ]);
    }
}
