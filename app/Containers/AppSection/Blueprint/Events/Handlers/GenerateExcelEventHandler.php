<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Events\Handlers;

use App\Containers\AppSection\Blueprint\Actions\GenerateExcelSubAction;
use App\Containers\AppSection\Blueprint\Data\Enums\BlueprintDocStatusEnum;
use App\Containers\AppSection\Blueprint\Events\Events\GenerateExcelEvent;
use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Containers\AppSection\Blueprint\Tasks\FindBlueprintDocByIdTask;
use App\Containers\AppSection\Blueprint\Tasks\UpdateBlueprintDocTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\UploadFileTask;
use App\Containers\AppSection\Notification\Events\Events\BlueprintDocGeneratedEvent;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateExcelEventHandler implements ShouldQueue
{
    public ?string $queue = 'documents';

    public function handle(GenerateExcelEvent $event): void
    {
        /** @var BlueprintDoc $doc */
        $doc = app(FindBlueprintDocByIdTask::class)
            ->withMember()
            ->withUser()
            ->run($event->docId);

        try {
            $filePath  = app(GenerateExcelSubAction::class)->run($doc);
            $file      = app(UploadFileTask::class)
                ->run($filePath, $doc->filename, $doc, MediaCollectionEnum::BLUEPRINT_DOC);
        } catch (Exception) {
            app(UpdateBlueprintDocTask::class)->run($doc->getKey(), [
                'status' => BlueprintDocStatusEnum::ERROR,
            ]);
            event(new BlueprintDocGeneratedEvent(
                $doc->user->getKey(),
                $doc->member->getHashedKey(),
                BlueprintDocStatusEnum::ERROR,
                $doc->getHashedKey(),
            ));

            return;
        }

        app(UpdateBlueprintDocTask::class)->run($doc->getKey(), [
            'status'    => BlueprintDocStatusEnum::SUCCESS,
            'media_id'  => $file->getKey(),
        ]);
        event(new BlueprintDocGeneratedEvent(
            $doc->user->getKey(),
            $doc->member->getHashedKey(),
            BlueprintDocStatusEnum::SUCCESS,
            $doc->getHashedKey(),
        ));
    }
}
