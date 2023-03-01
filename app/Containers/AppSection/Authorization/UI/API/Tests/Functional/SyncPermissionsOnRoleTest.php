<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;

/**
 * Class SyncPermissionsOnRoleTest.
 *
 * @group authorization
 * @group api
 */
class SyncPermissionsOnRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/permissions/sync';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testSyncDuplicatedPermissionsToRole(): void
    {
        /** @var Role $roleA */
        $roleA = Role::factory()->create();

        /** @var Permission $permissionA */
        $permissionA = Permission::factory()->create(['display_name' => 'AAA']);

        /** @var Permission $permissionB */
        $permissionB = Permission::factory()->create(['display_name' => 'BBB']);

        $roleA->givePermissionTo($permissionA);

        $data = [
            'role_id'         => $roleA->getHashedKey(),
            'permissions_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $this->assertDatabaseHas(config('permission.table_names.role_has_permissions'), [
            $permissionA->getForeignKey() => $permissionA->getKey(),
            $roleA->getForeignKey()       => $roleA->getKey(),
        ]);

        $this->assertDatabaseHas(config('permission.table_names.role_has_permissions'), [
            $permissionB->getForeignKey() => $permissionB->getKey(),
            $roleA->getForeignKey()       => $roleA->getKey(),
        ]);
    }
}
