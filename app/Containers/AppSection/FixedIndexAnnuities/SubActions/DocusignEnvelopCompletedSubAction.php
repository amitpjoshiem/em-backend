<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\SubActions;

use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignEnvelop;
use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\FindDocusignEnvelopByUuidTask;
use App\Containers\AppSection\Notification\Events\Events\DocusignEnvelopCompleteEvent;
use App\Ship\Parents\Actions\SubAction;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocusignEnvelopCompletedSubAction extends SubAction
{
    public function __construct()
    {
    }

    public function run(array $data): void
    {
        /** @var DocusignEnvelop $envelop */
        $envelop = app(FindDocusignEnvelopByUuidTask::class)->withRelations([
            'document',

        ])->run($data['envelopeId']);
        $documents = $data['envelopeSummary']['envelopeDocuments'];

        if (\count($documents) !== 2) {
            throw new Exception();
        }

        foreach ($documents as $document) {
            $name = $document['name'];

            if ($document['documentId'] === 'certificate') {
                $name .= '.pdf';
            }

            /** @psalm-suppress UndefinedInterfaceMethod */
            $tempPath  = Storage::disk('temp')->getDriver()->getAdapter()->getPathPrefix();
            $file_path = $tempPath . $name;
            file_put_contents($file_path, base64_decode($document['PDFBytes'], true));
            $file = new UploadedFile($file_path, $name);

            if ($document['documentId'] === 'certificate') {
                $envelop->document->updateCertificate($file);
            } else {
                $envelop->document->updateDocument($file);
            }
        }

        $fixedIndexAnnuityId = $envelop->document->getHashedKey();

        if ($envelop->document instanceof InvestmentPackage) {
            $fixedIndexAnnuityId = $envelop->document->fixedIndexAnnuities->getHashedKey();
        }

        event(new DocusignEnvelopCompleteEvent(
            $envelop->advisorRecipient->recipient->getKey(),
            $envelop->clientRecipient->recipient->getHashedKey(),
            $envelop->document->getResourceKey(),
            $fixedIndexAnnuityId
        ));
    }
}
