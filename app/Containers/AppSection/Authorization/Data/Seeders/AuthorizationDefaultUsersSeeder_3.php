<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Data\Transporters\CreateUserTransporter;
use App\Containers\AppSection\User\Models\Company;
use App\Containers\AppSection\User\SubActions\RegisterUserSubAction;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Parents\Seeders\Seeder;
use Illuminate\Support\Facades\Event;

class AuthorizationDefaultUsersSeeder_3 extends Seeder
{
    /**
     * Add Default Users (with their roles).
     */
    public function run(): void
    {
        $realEvent = Event::getFacadeRoot();
        Event::fake();

        Company::factory()->create([
            'name'   => 'SWD',
            'domain' => 'swdgroup.net',
        ])->each(function (Company $company): void {
            if (app()->runningUnitTests() || !config('app.is_development')) {
                $this->addBaseUser('admin@swdgroup.net', 'Q97ZgyvUvwBsuumf9NLdYmgx', 'Super Admin', RolesEnum::admin(), $company->id);

                return;
            }

            $this->addBaseUser('ceo@swdgroup.net', '111111', 'CEO', RolesEnum::ceo(), $company->id);
            $this->addBaseUser('ydimas+ceo@gmail.com', '111111', 'YDimas CEO', RolesEnum::ceo(), $company->id);
            $this->addBaseUser('admin@swdgroup.net', '111111', 'Super Admin', RolesEnum::admin(), $company->id);
            $this->addBaseUser('ydimas@gmail.com', '111111', 'YDmitriy', RolesEnum::advisor(), $company->id);
            $this->addBaseUser('vmerz@uinno.io', '111111', 'VMerz', RolesEnum::advisor(), $company->id);
            $this->addBaseUser('deb@sowise.tech', '111111', 'DebM', RolesEnum::advisor(), $company->id);
            $this->addBaseUser('preeti@engineersmind.com', '111111', 'PreetiL', RolesEnum::advisor(), $company->id);
            $this->addBaseUser('anil@engineersmind.com', '111111', 'AnilC', RolesEnum::advisor(), $company->id);
            $this->addBaseUser('support@engineersmind.com', '111111', 'Support', RolesEnum::support(), $company->id);
            $this->addBaseUser('support@engineersmind.com', '111111', 'Support', RolesEnum::support(), $company->id);
        });

        if (!app()->runningUnitTests() && config('app.is_development')) {
            Company::factory()->count(2)->create()->each(function (Company $company): void {
                $this->addBaseUser(sprintf('admin@%s', $company->domain), '111111', 'Admin ' . $company->name, RolesEnum::ceo(), $company->id);
                for ($i = 1; $i < random_int(2, 10); $i++) {
                    $this->addBaseUser(sprintf('user%d@%s', $i, $company->domain), '111111', $company->name . ' User ' . $i, RolesEnum::advisor(), $company->id);
                }
            });
        }

        Event::swap($realEvent);
    }

    private function addBaseUser(
        string $email,
        string $password,
        string $username,
        RolesEnum $role,
        int $company,
    ): void {
        $transporter = CreateUserTransporter::fromArrayable([
            'email'    => $email,
            'password' => $password,
            'username' => $username,
            'company'  => $company,
        ]);

        $user = app(RegisterUserSubAction::class)->run($transporter, $role, true);

        app(UpdateUserTask::class)->run(['last_login_at' => now()], $user->getKey());
    }
}
