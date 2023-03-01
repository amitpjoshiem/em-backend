<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

/**
 * Class RevokeUserFromRoleTest.
 *
 * @group authorization
 * @group api
 */
class RevokeUserFromRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/roles/revoke';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ADMINS_ACCESS,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testRevokeUserFromRole(): void
    {
        /** @var Role $roleA */
        $roleA = Role::factory()->create();

        /** @var User $randomUser */
        $randomUser = User::factory()->create();

        $randomUser->assignRole($roleA);

        $data = [
            'roles_ids' => [$roleA->getHashedKey()],
            'user_id'   => $randomUser->getHashedKey(),
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($data['user_id'], $responseContent->data->id);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_roles'), [
            'model_id' => $randomUser->getKey(),
            'role_id'  => $roleA->getKey(),
        ]);
    }

    /**
     * @test
     */
    public function testRevokeUserFromRoleWithRealId(): void
    {
        /** @var Role $roleA */
        $roleA = Role::factory()->create();

        /** @var User $randomUser */
        $randomUser = User::factory()->create();

        $randomUser->assignRole($roleA);

        $data = [
            'roles_ids' => [$roleA->getKey()],
            'user_id'   => $randomUser->getKey(),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct. Note: this will return 200 if `HASH_ID=false` in the .env
        if (config('apiato.hash-id')) {
            $response->assertStatus(422);

            $this->assertResponseContainKeyValue([
                'message' => 'The given data was invalid.',
            ]);
        } else {
            $response->assertStatus(200);
        }
    }

    /**
     * @test
     */
    public function testRevokeUserFromManyRoles(): void
    {
        /** @var Role $roleA */
        $roleA = Role::factory()->create();

        /** @var Role $roleB */
        $roleB = Role::factory()->create();

        /** @var User $randomUser */
        $randomUser = User::factory()->create();

        $randomUser->assignRole($roleA);
        $randomUser->assignRole($roleB);

        $data = [
            'roles_ids' => [$roleA->getHashedKey(), $roleB->getHashedKey()],
            'user_id'   => $randomUser->getHashedKey(),
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_roles'), [
            'model_id' => $randomUser->getKey(),
            'role_id'  => $roleA->getKey(),
        ]);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_roles'), [
            'model_id' => $randomUser->getKey(),
            'role_id'  => $roleB->getKey(),
        ]);
    }
}
