<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Tests\ApiTestCase;

/**
 * Class GetAllRolesTest.
 *
 * @group authorization
 * @group api
 */
class GetAllRolesTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/roles';

    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testGetAllRoles(): void
    {
        $this->getTestingUser();

        $response = $this->makeCall();

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertTrue((is_countable($responseContent->data) ? \count($responseContent->data) : 0) > 0);
    }
}
