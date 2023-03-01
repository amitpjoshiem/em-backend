<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit;

use App\Containers\AppSection\User\Actions\RegisterUserAction;
use App\Containers\AppSection\User\Data\Transporters\CreateUserTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\TestCase;
use Illuminate\Support\Facades\Event;
use function app;

/**
 * Class CreateUserTest.
 *
 * @group user
 * @group unit
 */
class RegisterUserTest extends TestCase
{
    /**
     * @test
     */
    public function testCreateUser(): void
    {
        $data = [
            'email'    => 'Test@test.test',
            'password' => 'so-secret',
            'username' => 'Test',
        ];

        Event::fake();

        $userData = new CreateUserTransporter($data);
        $user     = app(RegisterUserAction::class)->run($userData);

        self::assertInstanceOf(User::class, $user);

        self::assertEquals($user->username, $data['username']);
    }
}
