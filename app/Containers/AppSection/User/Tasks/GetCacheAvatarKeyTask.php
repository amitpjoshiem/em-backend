<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Ship\Parents\Tasks\Task;

class GetCacheAvatarKeyTask extends Task
{
    public function run(int $userId): string
    {
        return sprintf('user.%s.avatar_url', $userId);
    }
}
