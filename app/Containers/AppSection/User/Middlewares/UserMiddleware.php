<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Middlewares;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Exceptions\UserHeaderException;
use App\Containers\AppSection\User\Helper\UserHelper;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindCompanyByIdTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Vinkla\Hashids\Facades\Hashids;

class UserMiddleware
{
    public function __construct(private AuthManager $auth)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param string|null ...$guards
     *
     * @psalm-return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $xUser = $this->checkHeader($request, 'x-user');

        if ($xUser === null) {
            throw new UserHeaderException('Wrong x-user Header');
        }

        $xCompany = $this->checkHeader($request, 'x-company');

        if ($xCompany === null) {
            throw new UserHeaderException('Wrong x-company Header');
        }

        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $company = app(FindCompanyByIdTask::class)->run($xCompany);

        /** @var User $newUser */
        $newUser = app(FindUserByIdTask::class)->run($xUser);

        if ($user->hasRole([RolesEnum::ADMIN, RolesEnum::ADVISOR])) {
            /** @var User $newUser */
            $newUser = app(FindUserByIdTask::class)->run($xUser);

            if ($newUser->company->getKey() !== $user->company->getKey()) {
                throw new UserHeaderException('Can`t Access to this User');
            }
        } elseif ($user->hasRole(RolesEnum::ASSISTANT)) {
            if ($newUser->hasRole(RolesEnum::ADVISOR) && !$user->advisors->contains('id', $xUser) && $user->getKey() !== $newUser->getKey()) {
                throw new UserHeaderException('Can`t Access to this User');
            }

            if ($newUser->hasRole(RolesEnum::CLIENT) && !$user->advisors->contains('id', $newUser->client?->member->user_id)) {
                throw new UserHeaderException('Can`t Access to this User');
            }
        }

        Passport::actingAs($newUser);
        UserHelper::setInstance($user, $newUser, $company);

        return $next($request);
    }

    private function checkHeader(Request $request, string $header): ?int
    {
        if (!$request->hasHeader($header)) {
            return null;
        }

        $hash = $request->header($header);

        if (!\is_string($hash)) {
            return null;
        }

        $decoded = Hashids::decode($hash);

        if (!isset($decoded[0])) {
            return null;
        }

        return $decoded[0];
    }
}
