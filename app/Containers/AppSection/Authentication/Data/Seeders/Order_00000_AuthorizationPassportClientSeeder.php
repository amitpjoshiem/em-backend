<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Data\Seeders;

use App\Ship\Parents\Seeders\Seeder;
use Laravel\Passport\Passport;

class Order_00000_AuthorizationPassportClientSeeder extends Seeder
{
    public function run(): void
    {
        $this->createPassportClient(1, config('app.name') . ' Password Grant Client', 'q1iOysZz1MlaQAaSEifJmoLAgOxETxZ7jB67w7e4', 'users', 'http://localhost', true);
        $this->createPassportClient(2, config('app.name') . ' Authorization Code Grant with PKCE', null, null, config('app.url') . '/auth');
    }

    private function createPassportClient(?int $id, string $name, ?string $confidential, ?string $provider, string $redirect, bool $password = false): void
    {
        $client = Passport::client()->forceFill([
            'id'                     => $id,
            'user_id'                => null,
            'name'                   => $name,
            'secret'                 => $confidential,
            'provider'               => $provider,
            'redirect'               => $redirect,
            'personal_access_client' => false,
            'password_client'        => $password,
            'revoked'                => false,
        ]);

        $client->save();
    }
}
