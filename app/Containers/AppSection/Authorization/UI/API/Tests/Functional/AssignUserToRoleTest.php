<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Arr;

/**
 * Class AssignUserToRoleTest.
 *
 * @group authorization
 * @group api
 */
class AssignUserToRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/roles/assign?include=roles';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ADMINS_ACCESS,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testAssignUserToRole(): void
    {
        $randomUser = User::factory()->create();
        $role       = Role::factory()->create();

        $data = [
            'roles_ids' => [$role->getHashedKey()],
            'user_id'   => $randomUser->getHashedKey(),
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($data['user_id'], $responseContent->data->id);

        self::assertEquals($data['roles_ids'][0], $responseContent->data->roles[0]->id);
    }

    /**
     * @test
     */
    public function testAssignUserToRoleWithRealId(): void
    {
        /** @var Role $role */
        $role = Role::factory()->create();

        /** @var User $randomUser */
        $randomUser = User::factory()->create();

        $data = [
            'roles_ids'               => [$role->getKey()], // testing against real ID's
            $randomUser->getKeyName() => $randomUser->getKey(), // testing against real ID's
        ];

        $response = $this->makeCall($data);

        // Assert response status is correct. Note: this will return 200 if `HASH_ID=false` in the .env
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
    public function testAssignUserToManyRoles(): void
    {
        $randomUser = User::factory()->create();
        $role1      = Role::factory()->create();
        $role2      = Role::factory()->create();

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
