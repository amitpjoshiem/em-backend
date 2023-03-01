<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Init\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Init\Data\Transporters\OutputInitTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class GetAllInitAction extends Action
{
    public function run(): OutputInitTransporter
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $data = new OutputInitTransporter([
            'roles'      => $user->roles,
            'user_id'    => $user->getHashedKey(),
            'company_id' => $user->company->getHashedKey(),
            'advisor_id' => $user->advisors?->first()?->getHashedKey(),
        ]);

        if ($user->hasRole([RolesEnum::CLIENT, RolesEnum::LEAD])) {
            $data->terms_and_conditions = $user->client->terms_and_conditions;
            $data->member_type          = $user->client->member->type;
            $data->member_id            = $user->client->member->getHashedKey();
            $data->readonly             = $user->client->readonly;
        }

        return $data;
    }
}
