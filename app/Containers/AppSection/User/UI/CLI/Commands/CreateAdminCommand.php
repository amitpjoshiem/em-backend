<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\CLI\Commands;

use App\Containers\AppSection\User\Actions\CreateAdminAction;
use App\Containers\AppSection\User\Data\Transporters\CreateUserTransporter;
use App\Ship\Parents\Commands\ConsoleCommand;

class CreateAdminCommand extends ConsoleCommand
{
    /** @var string */
    protected $signature = 'apiato:create:admin';

    /** @var string */
    protected $description = 'Create a new User with the ADMIN role';

    public function handle(): void
    {
        $username             = $this->ask('Enter the username for this user');
        $email                = $this->ask('Enter the email address of this user');
        $companyId            = $this->ask('Enter the company ID of this user');
        $password             = $this->secret('Enter the password for this user');
        $passwordConfirmation = $this->secret('Please confirm the password');

        if ($password !== $passwordConfirmation) {
            $this->error('Passwords do not match - exiting!');

            return;
        }

        $userData = new CreateUserTransporter([
            'username'              => $username,
            'email'                 => $email,
            'password'              => $password,
            'password_confirmation' => $password,
            'company'               => $companyId,
        ]);

        $user = app(CreateAdminAction::class)->run($userData);

        $this->info(sprintf('Admin %s was successfully created', $user->email));
    }
}
