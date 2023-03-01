<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Tasks;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class GetChannelNameByUserTask extends Task
{
    public function run(User $user): string
    {
        return 'notification_' . $user->getHashedKey();
    }
}
