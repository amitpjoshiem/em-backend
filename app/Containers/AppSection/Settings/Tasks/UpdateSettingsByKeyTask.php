<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Tasks;

use App\Containers\AppSection\Settings\Data\Repositories\SettingRepository;
use App\Containers\AppSection\Settings\Models\Setting;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateSettingsByKeyTask extends Task
{
    public function __construct(protected SettingRepository $repository)
    {
    }

    public function run(string $key, string $value): Setting
    {
        $setting = $this->repository->findWhere(['key' => $key])->first();

        if (!$setting) {
            throw new NotFoundException();
        }

        try {
            return $this->repository->update([
                'value' => $value,
            ], $setting->id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}
