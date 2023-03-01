<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit;

use App\Containers\AppSection\Authentication\Actions\WebLoginAction;
use App\Containers\AppSection\Authentication\Data\Transporters\WebLoginTransporter;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Exceptions\UserNotConfirmedException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\TestCase;
use Illuminate\Support\Facades\Config;

/**
 * Class LoginTest.
 *
 * @group authentication
 * @group unit
 */
class LoginTest extends TestCase
{
    private array $userDetails;

    private WebLoginTransporter $request;

    private WebLoginAction $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->userDetails = [
            'email'    => 'test@test.test',
            'password' => 'so-secret',
            'username' => 'test',
        ];

        $user = $this->getTestingUser($this->userDetails);
        $this->actingAs($user, 'web');
        $this->request = WebLoginTransporter::fromArrayable($this->userDetails);
        $this->action  = app(WebLoginAction::class);
    }

    public function testLogin(): void
    {
        $user = $this->action->run($this->request);

        self::assertInstanceOf(User::class, $user);
        self::assertSame($user->username, $this->userDetails['username']);
    }

    public function testLoginWithInvalidCredentialsThrowsAnException(): void
    {
        $this->expectException(LoginFailedException::class);

        $this->request = WebLoginTransporter::fromArrayable(['email' => 'wrong@email.com', 'password' => 'wrong_password']);

        $this->action->run($this->request);
    }

    public function testGivenEmailConfirmationIsRequiredAndUserIsNotConfirmedThrowsAnException(): void
    {
        $this->expectException(UserNotConfirmedException::class);

        $configInitialValue = config('appSection-authentication.require_email_confirmation');
        Config::set('appSection-authentication.require_email_confirmation', true);
        $user                    = $this->getTestingUser();
        $user->email_verified_at = null;
        $user->save();

        $this->action->run($this->request);

        Config::set('appSection-authentication.require_email_confirmation', $configInitialValue);
    }
}
