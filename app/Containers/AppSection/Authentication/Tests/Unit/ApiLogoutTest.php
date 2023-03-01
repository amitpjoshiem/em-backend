<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit;

use App\Containers\AppSection\Authentication\Tasks\GetJtiByTokenTask;
use App\Containers\AppSection\Authentication\Tests\TestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Token;

/**
 * Class ApiLogoutTest.
 *
 * @group authentication
 * @group unit
 */
class ApiLogoutTest extends TestCase
{
    public function testLogoutByToken(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        $token = $user->createToken('test-oauth-client-name')->accessToken;

        // Passport's token parsing is looking to a bearer token using a protected method.
        $request = app(Request::class);
        $request->headers->add(['Authorization' => sprintf('Bearer %s', $token)]);

        $token = $request->bearerToken();

        self::assertNotNull($token);

        $tokenId = app(GetJtiByTokenTask::class)->run($token);

        // Assert data was updated in the database
        $this->assertDatabaseHas(Token::class, ['id' => $tokenId]);

        $isRevoked = DB::table('oauth_access_tokens')
            ->where('id', $tokenId)
            ->update(['revoked' => true]);

        self::assertEquals(1, $isRevoked);

        // Assert data was updated in the database
        $this->assertDatabaseHas(Token::class, ['id' => $tokenId, 'revoked' => true]);
    }
}
