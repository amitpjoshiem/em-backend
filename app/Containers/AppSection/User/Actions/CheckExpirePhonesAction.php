<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\SubActions\CheckUserPhoneExpireSubAction;
use App\Ship\Parents\Actions\Action;

class CheckExpirePhonesAction extends Action
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function run(): void
    {
        $warningDays = config('appSection-user.phone_expire_warning_days');
        $expireDays  = config('appSection-user.phone_expire_days');
        $warningDate = now()->subDays($expireDays - $warningDays);
        $users       = $this->repository->findWhere([
            ['phone_verified_at', 'DATE <=', $warningDate->format('Y-m-d')],
        ]);
        /** @var User $user */
        foreach ($users as $user) {
            app(CheckUserPhoneExpireSubAction::class)->run($user);
        }
    }
}
