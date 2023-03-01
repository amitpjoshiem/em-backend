<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;

/**
 * Class CreateRoleTest.
 *
 * @group authorization
 * @group api
 */
class CreateRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/roles';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    public function testCreateRole(): void
    {
        $data = [
            'name'         => 'manager',
            'display_name' => 'manager',
            'description'  => 'he manages things',
            'level'        => 7,
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($data['name'], $responseContent->data->name);
        self::assertEquals($data['level'], $responseContent->data->level);
    }

    public function testCreateRoleWithoutLevel(): void
    {
        $data = [
            'name'         => 'manager',
            'display_name' => 'manager',
            'description'  => 'he manages things',
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals(0, $responseContent->data->level);
    }

    public function testCreateRoleWithWrongName(): void
    {
        $data = [
            'name'         => 'include Space',
            'display_name' => 'manager',
            'description'  => 'he manages things',
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(422);
    }
}
