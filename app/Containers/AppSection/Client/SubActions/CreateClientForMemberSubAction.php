<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\SubActions;

use App\Containers\AppSection\Admin\Actions\SendCreatePasswordSubAction;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Tasks\AssignUserToRolesTask;
use App\Containers\AppSection\Client\Tasks\SaveClientTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Parents\Actions\SubAction;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function app;

class CreateClientForMemberSubAction extends SubAction
{
    public function run(int $memberId): void
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->withRelations(['user.company', 'client'])->run($memberId);

        if ($member->client !== null) {
            return;
        }

        $client = app(CreateUserByCredentialsTask::class)->run(
            $member->email,
            Hash::make(Str::random()),
            $member->email,
            $member->user->company->getKey(),
            phone: $member->phone,
        );

        try {
            [$firstName, $lastName] = explode(' ', $member->name, 2);
        } catch (Exception) {
            $lastName  = $member->name;
            $firstName = '';
        }

        $client = app(UpdateUserTask::class)->run([
            'first_name' => $firstName,
            'last_name'  => $lastName,
        ], $client->getKey());

        $role = match ($member->type) {
            Member::PRE_LEAD, Member::LEAD, Member::PROSPECT => RolesEnum::LEAD,
            Member::CLIENT => RolesEnum::CLIENT,
        };

        app(AssignUserToRolesTask::class)->run($client, [$role]);

        app(SendCreatePasswordSubAction::class)->run($client);

        $termsAndConditions = match ($member->type) {
            Member::PROSPECT, Member::CLIENT => true,
            Member::PRE_LEAD, Member::LEAD => false,
        };

        /** @FIXME Remove Readonly but maybe in future they want to get back readonly */
//        $readonly = match ($member->type) {
//            Member::PROSPECT => true,
//            Member::PRE_LEAD, Member::LEAD, Member::CLIENT => false,
//        };

        app(SaveClientTask::class)->run($client->getKey(), $member->getKey(), [
            //            'readonly'             => $readonly,
            'terms_and_conditions' => $termsAndConditions,
        ]);
    }
}
