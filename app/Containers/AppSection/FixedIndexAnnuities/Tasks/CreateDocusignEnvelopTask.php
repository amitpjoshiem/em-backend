<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\DocusignEnvelopRepository;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocumentInterface;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignEnvelop;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateDocusignEnvelopTask extends Task
{
    public function __construct(protected DocusignEnvelopRepository $repository)
    {
    }

    public function run(DocumentInterface $document, int $advisorRecipientId, int $clientRecipientId, string $envelopId): DocusignEnvelop
    {
        try {
            return $this->repository->create([
                'document_id'           => $document->getKey(),
                'document_type'         => $document::class,
                'advisor_recipient_id'  => $advisorRecipientId,
                'client_recipient_id'   => $clientRecipientId,
                'envelop_id'            => $envelopId,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
