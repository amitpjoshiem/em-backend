<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\UI\API\Tests\Functional;

use App\Containers\AppSection\Authentication\Tests\ApiTestCase;
use Laravel\Passport\Passport;

/**
 * Class ApiLogoutTest.
 *
 * @group authentication
 * @group api
 */
class ApiLogoutTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/logout';

    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function testLogout(): void
    {
        $user = $this->getTestingUser();
        Passport::actingAs($user);

        $response = $this->makeCall([], [
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGVhYjMzMDA3NzEzZDMxMzI4ODIwNzgwY2Y2YzA4N2NhY2JmMGMyMzg2ZTk1MzM0N2IxYzM3MTdkMDk2MjljZjdiZmE3MWIxYWM3NThkNjIiLCJpYXQiOjE2MjI3MzQxNzIuNDkyODQyLCJuYmYiOjE2MjI3MzQxNzIuNDkyODQ2LCJleHAiOjE2MzEzNzQxNzIuNDI5NTc3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.g_1qgFhoz47P6EOcKcVUWEV_-8Th07so0tMJ-B-XGhKqVL2-TDWeRllEksNzn2bVKJjYya21_gm-a8GNiquNkq0jLPq8sGhIMw-TvpE73_tno03OWYfOAMxWdlqKK77SKdbwvtoxbL1KOHYWwQcebf8s7Isflf4zo5nJJMef0gG0VwjZ1YG1z_LFQYbl4awwgKAH9EgPHKUoDilelg2qqorP1qz2bd0sgD1eyCMxmhUk7qfieSFM-8Htwp1Q5bptVLfCnnVbHdgY_SZhvDmrhrOJd-5uKhxexCl0xlXeXV6h_fMm-0OJbHM9hGrrqPiiLeq9WUvmh6qXj-N_LNIL4MN4HMYtQx3JSrRBxXf99mPCkItVMoEMECB_YBbGqPSmhaTHnDZDjyvD2F_lHZ7KEpDpGKUdjXdWLgdtGihUKI-KkTw0KWXZSDS2nf7Lxt-FumLWQPSZZYBOpaw6yCjRkGJehBQowwDwCFlDNVGdGP5Qre2nOiwvZKF3Nh7gBA0ssxKizWUnv9UVfl38a45TqjHkA-PTS8VXhAwCwKS8g3kU9GMwFPlgLtKdtJdZCF8_rpYQTudrIJfqzHkuhzCG1McYbrcQ8p8kVPrgWdFzRySHrYYsxTezc-aIuwbG_nmyvwSn4JlddqlWXWi1kw82t_fU4r1ldJzp5FDt0zJmySI',
        ]);

        $response->assertStatus(202);

        $this->assertResponseContainKeyValue([
            'message' => 'Token revoked successfully.',
        ]);
    }
}
