<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Tasks;

use App\Containers\AppSection\Settings\Data\Repositories\SettingRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;

class FindSettingByKeyTask extends Task
{
    public function __construct(protected SettingRepository $repository)
    {
    }

    public function run(string $key): string
    {
        $result = $this->repository->findWhere(['key' => $key])->first();

        if (!$result) {
            throw new NotFoundException();
        }

        return $result->value;
    }
}
