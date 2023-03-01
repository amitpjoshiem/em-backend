<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\SubActions;

use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignEnvelop;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignRecipient;
use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\FindDocusignEnvelopByUuidTask;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\FindDocusignRecipientByIdTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Notification\Events\Events\DocusignUserSignedEvent;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Support\Carbon;

class DocusignRecipientCompletedSubAction extends SubAction
{
    public function __construct()
    {
    }

    public function run(array $data): void
    {
        /** @var DocusignEnvelop $envelop */
        $envelop = app(FindDocusignEnvelopByUuidTask::class)->withRelations([
            'document',
            'advisorRecipient',
            'clientRecipient',
        ])->run($data['envelopeId']);

        /** @var DocusignRecipient $recipient */
        $recipient = app(FindDocusignRecipientByIdTask::class)
            ->withRelations(['recipient'])
            ->run((int)$data['recipientId']);

        $signers = $data['envelopeSummary']['recipients']['signers'];
        $date    = now();
        foreach ($signers as $signer) {
            if ((int)$signer['recipientId'] === $recipient->getKey()) {
                $date = Carbon::create($signer['signedDateTime']);
                break;
            }
        }

        if ($recipient->recipient instanceof User) {
            $envelop->document->advisorSign($date);
        } elseif ($recipient->recipient instanceof Member) {
            $envelop->document->clientSign($date);
        }

        $fixedIndexAnnuityId = $envelop->document->getHashedKey();

        if ($envelop->document instanceof InvestmentPackage) {
            $fixedIndexAnnuityId = $envelop->document->fixedIndexAnnuities->getHashedKey();
        }

        event(new DocusignUserSignedEvent(
            $envelop->advisorRecipient->recipient->getKey(),
            $envelop->clientRecipient->recipient->getHashedKey(),
            $recipient->recipient->getName(),
            $envelop->document->getResourceKey(),
            $fixedIndexAnnuityId
        ));
    }
}
