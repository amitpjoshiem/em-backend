<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\SubActions;

use App\Containers\AppSection\FixedIndexAnnuities\Exceptions\DocumentAlreadyCompletedException;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocumentInterface;
use App\Containers\AppSection\FixedIndexAnnuities\Services\DocuSignService;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\CreateDocusignRecipientTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\SubAction;

class GetEnvelopUrlSubAction extends SubAction
{
    public function __construct(protected DocuSignService $docuSignService)
    {
    }

    public function run(DocumentInterface $document, int $userId, int $memberId): ?string
    {
        if ($document->isCompleted()) {
            throw new DocumentAlreadyCompletedException();
        }

        /** @var User $user */
        $user = app(FindUserByIdTask::class)->withRelations(['recipient.recipient'])->run($userId);

        $advisor = $user->recipient;

        if ($advisor === null) {
            $advisor = app(CreateDocusignRecipientTask::class)->run($user);
        }

        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->withRelations(['recipient.recipient'])->run($memberId);

        $client = $member->recipient;

        if ($client === null) {
            $client = app(CreateDocusignRecipientTask::class)->run($member);
        }

        return $this->docuSignService->getEnvelopUrl($document, $advisor, $client);
    }
}
