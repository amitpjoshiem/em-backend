<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Init\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Init\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

/**
 * Class GetAllInitTest.
 *
 * @group init
 * @group api
 */
class GetAllInitTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/init';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testGetAllInit(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        $user->assignRole(RolesEnum::ADVISOR);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $content = $response->json();

        $this->assertEquals($content['data']['roles'][0], RolesEnum::ADVISOR);
    }
}
