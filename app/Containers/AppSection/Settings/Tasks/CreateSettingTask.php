<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Tasks;

use App\Containers\AppSection\Settings\Data\Repositories\SettingRepository;
use App\Containers\AppSection\Settings\Models\Setting;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateSettingTask extends Task
{
    public function __construct(protected SettingRepository $repository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(array $data): Setting
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
