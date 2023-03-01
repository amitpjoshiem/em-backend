<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Seeders;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Data\Transporters\CreateUserTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\SubActions\RegisterUserSubAction;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Parents\Seeders\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class ClientSeeder_5 extends Seeder
{
    public function run(): void
    {
        if (app()->runningUnitTests() || !config('app.is_development')) {
            return;
        }

        $realEvent = Event::getFacadeRoot();
        Event::fake();

        /** @var Member $member */
        foreach (Member::with('user')->get() as $member) {
            DB::beginTransaction();

            if ($member->type === Member::LEAD) {
                $user  = $this->addBaseUser($member->email, '111111', $member->name, RolesEnum::lead(), $member->user->company_id);

                Client::factory()->create([
                    'member_id'           => $member->getKey(),
                    'user_id'             => $user->getKey(),
                    'converted_from_lead' => null,
                ]);
            } elseif ($member->type === Member::CLIENT) {
                $user  = $this->addBaseUser($member->email, '111111', $member->name, RolesEnum::client(), $member->user->company_id);

                Client::factory()->create([
                    'member_id'           => $member->getKey(),
                    'user_id'             => $user->getKey(),
                    'converted_from_lead' => $member->created_at->addDays(2),
                ]);
            }

            DB::commit();
        }

        Event::swap($realEvent);
    }

    private function addBaseUser(
        string $email,
        string $password,
        string $username,
        RolesEnum $role,
        int $company,
    ): User {
        $transporter = CreateUserTransporter::fromArrayable([
            'email'    => $email,
            'password' => $password,
            'username' => $username,
            'company'  => $company,
        ]);

        $user = app(RegisterUserSubAction::class)->run($transporter, $role, true);

        app(UpdateUserTask::class)->run(['last_login_at' => now()], $user->getKey());

        return $user;
    }
}
