<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Container\Container;

class ActingAsUserTask extends Task
{
    public function __construct(private Container $app)
    {
    }

    public function run(UserModel $user, ?string $driver = 'web'): void
    {
        $this->app['auth']->guard($driver)->setUser($user);
        $this->app['auth']->shouldUse($driver);
    }
}
