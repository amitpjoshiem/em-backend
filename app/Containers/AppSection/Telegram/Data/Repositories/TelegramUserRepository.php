<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class TelegramUserRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
