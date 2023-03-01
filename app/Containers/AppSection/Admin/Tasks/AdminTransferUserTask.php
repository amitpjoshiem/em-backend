<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsExportRepository;
use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintDocRepository;
use App\Containers\AppSection\Client\Data\Repositories\ClientRepository;
use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportsDocRepository;
use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAttachmentRepository;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Containers\AppSection\User\Data\Repositories\UsersTransferRepository;
use App\Containers\AppSection\Yodlee\Data\Repositories\YodleeAccountsRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

class AdminTransferUserTask extends Task
{
    private array $updateRepositories = [
        MemberRepository::class,
        AssetsConsolidationsExportRepository::class,
        BlueprintDocRepository::class,
        ClientRepository::class,
        ClientReportsDocRepository::class,
        SalesforceChildOpportunityRepository::class,
        SalesforceAttachmentRepository::class,
        YodleeAccountsRepository::class,
    ];

    public function __construct(protected UsersTransferRepository $transferRepository)
    {
    }

    /**
     * @throws ValidatorException|CreateResourceFailedException
     */
    public function run(int $fromId, int $toId): bool
    {
        try {
            DB::beginTransaction();
            foreach ($this->updateRepositories as $repositoryClass) {
                /** @var Repository $repository */
                $repository = app($repositoryClass);
                /** @var Collection $items */
                $items = $repository->findByField('user_id', $fromId);
                $items->each(function (Model $model) use ($fromId, $toId, $repositoryClass): void {
                    $this->transferRepository->create([
                        'from_id'          => $fromId,
                        'to_id'            => $toId,
                        'model_repository' => $repositoryClass,
                        'model_id'         => $model->getKey(),
                    ]);
                });
                $repository->pushCriteria(new ThisEqualThatCriteria('user_id', $fromId));
                $repository->updateByCriteria(['user_id' => $toId]);
            }

            DB::commit();
        } catch (Exception $exception) {
            throw (new UpdateResourceFailedException())->debug($exception);
        }

        return true;
    }
}
