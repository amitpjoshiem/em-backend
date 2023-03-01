<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Tasks;

use App\Containers\AppSection\Settings\Data\Repositories\SettingRepository;
use App\Containers\AppSection\Settings\Models\Setting;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteSettingTask extends Task
{
    public function __construct(protected SettingRepository $repository)
    {
    }

    /**
     * @throws DeleteResourceFailedException
     */
    public function run(Setting $setting): bool
    {
        try {
            return (bool)$this->repository->delete($setting->id);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}
