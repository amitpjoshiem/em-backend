<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UsersTransferRepository;
use App\Containers\AppSection\User\Models\UsersTransfer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

class AdminRestoreTransferUserTask extends Task
{
    public function __construct(protected UsersTransferRepository $transferRepository)
    {
    }

    /**
     * @throws ValidatorException|CreateResourceFailedException
     */
    public function run(int $fromId): bool
    {
        try {
            DB::beginTransaction();
            /** @var Collection $items */
            $items = $this->transferRepository->findByField('from_id', $fromId);
            $items->each(function (UsersTransfer $transfer): void {
                /** @var Repository $repository */
                $repository = app($transfer->model_repository);
                $repository->update(['user_id' => $transfer->from_id], $transfer->model_id);

                $transfer->delete();
            });
            DB::commit();
        } catch (Exception $exception) {
            throw (new UpdateResourceFailedException())->debug($exception);
        }

        return true;
    }
}
