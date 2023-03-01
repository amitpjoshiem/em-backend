<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Token;

class GetUserValidTokenTask extends Task
{
    public function run(int $userId): ?Model
    {
        return Token::query()
            ->where('user_id', $userId)
            ->where('revoked', false)
            ->where('expires_at', '<', 'now()')
            ->orderBy('created_at')
            ->get()
            ->last();
    }
}
