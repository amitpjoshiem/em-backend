<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintDocRepository;
use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class UpdateBlueprintDocTask extends Task
{
    public function __construct(protected BlueprintDocRepository $repository)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function run(int $docId, array $data): BlueprintDoc
    {
        return $this->repository->update($data, $docId);
    }
}
