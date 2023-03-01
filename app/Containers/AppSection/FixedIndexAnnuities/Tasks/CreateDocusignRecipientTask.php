<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\DocusignRecipientRepository;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignRecipient;
use App\Containers\AppSection\FixedIndexAnnuities\Models\RecipientInterface;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateDocusignRecipientTask extends Task
{
    public function __construct(protected DocusignRecipientRepository $repository)
    {
    }

    public function run(RecipientInterface $recipient): DocusignRecipient
    {
//        try {
        return $this->repository->create([
            'recipient_id'    => $recipient->getKey(),
            'recipient_type'  => $recipient::class,
        ]);
//        } catch (Exception $e) {
//            throw new CreateResourceFailedException(previous: $e);
//        }
    }
}
