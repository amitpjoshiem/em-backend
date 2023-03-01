<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\DocusignEnvelopRepository;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignEnvelop;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;
use Exception;

class FindDocusignEnvelopByUuidTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected DocusignEnvelopRepository $repository)
    {
    }

    public function run(string $uuid): ?DocusignEnvelop
    {
//        try {
        return $this->repository->findByField('envelop_id', $uuid)->first();
//        } catch (Exception $e) {
//            throw new NotFoundException(previous: $e);
//        }
    }
}
