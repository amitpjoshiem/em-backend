<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Enums\Enum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetPermissionCollectionViaEnumsTask extends Task
{
    /**
     * @param Enum[] $enums
     *
     * @throws CreateResourceFailedException
     */
    public function run(array $enums): Collection
    {
        $task = app(CreatePermissionByEnumTask::class);
        $pms  = new Collection();

        foreach ($enums as $enum) {
            $pms[$enum->value] = $task->run($enum);
        }

        return $pms;
    }
}
