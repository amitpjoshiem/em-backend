<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Data\Repositories;

use App\Containers\AppSection\Settings\Models\Setting;
use App\Ship\Parents\Repositories\Repository;

class SettingRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'  => '=',
        'key' => '=',
    ];

    public function model(): string
    {
        return Setting::class;
    }
}
