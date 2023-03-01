<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Tasks;

use App\Containers\AppSection\Settings\Data\Repositories\SettingRepository;
use App\Containers\AppSection\Settings\Models\Setting;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindSettingByIdTask extends Task
{
    public function __construct(protected SettingRepository $repository)
    {
    }

    public function run(int $id): ?Setting
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }
}
