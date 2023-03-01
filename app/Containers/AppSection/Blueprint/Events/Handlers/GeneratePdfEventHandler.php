<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Events\Handlers;

use App\Containers\AppSection\Blueprint\Data\Enums\BlueprintDocStatusEnum;
use App\Containers\AppSection\Blueprint\Events\Events\GeneratePdfEvent;
use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Containers\AppSection\Blueprint\Tasks\CalculateBlueprintMonthlyIncomeTask;
use App\Containers\AppSection\Blueprint\Tasks\CalculateBlueprintNetWorthPercentageTask;
use App\Containers\AppSection\Blueprint\Tasks\FindBlueprintDocByIdTask;
use App\Containers\AppSection\Blueprint\Tasks\GetBlueprintConcernByMemberIdTask;
use App\Containers\AppSection\Blueprint\Tasks\GetBlueprintMonthlyIncomeByMemberIdTask;
use App\Containers\AppSection\Blueprint\Tasks\GetBlueprintNetWorthByMemberIdTask;
use App\Containers\AppSection\Blueprint\Tasks\UpdateBlueprintDocTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\UploadFileTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Notification\Events\Events\BlueprintDocGeneratedEvent;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use mikehaertl\wkhtmlto\Pdf;

class GeneratePdfEventHandler implements ShouldQueue
{
    public ?string $queue = 'documents';

    public function handle(GeneratePdfEvent $event): void
    {
        /** @var BlueprintDoc $doc */
        $doc = app(FindBlueprintDocByIdTask::class)
            ->withMember()
            ->withUser()
            ->run($event->docId);

        try {
            $filePath = $this->getPdf($doc->member, $doc->filename);
            $pdf      = app(UploadFileTask::class)
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
            'media_id'  => $pdf->getKey(),
        ]);
        event(new BlueprintDocGeneratedEvent(
            $doc->user->getKey(),
            $doc->member->getHashedKey(),
            BlueprintDocStatusEnum::SUCCESS,
            $doc->getHashedKey(),
        ));
    }

    private function getPdf(Member $member, string $fileName): string
    {
        $concern       = app(GetBlueprintConcernByMemberIdTask::class)->run($member->getKey());
        $monthlyIncome = app(GetBlueprintMonthlyIncomeByMemberIdTask::class)->run($member->getKey());
        $netWorth      = app(GetBlueprintNetWorthByMemberIdTask::class)->run($member->getKey());
        $view          = view('appSection@blueprint::pdf', [
            'netWorth'      => app(CalculateBlueprintNetWorthPercentageTask::class)->run($netWorth),
            'monthlyIncome' => app(CalculateBlueprintMonthlyIncomeTask::class)->run($monthlyIncome),
            'concern'       => $concern?->toArray(),
            'name'          => $member->name,
            'year'          => now()->year,
        ])->render();
        $filePath     = sprintf('%s/%s', config('appSection-blueprint.pdf_report_tmp_path'), $fileName);
        $options      = [
            'user-style-sheet' => resource_path('assets/css/blueprint_report.css'),
            'run-script'       => [
                resource_path('assets/js/blueprint_report.js'),
            ],
            'orientation' => 'landscape',
            'no-outline',         // Make Chrome not complain
            'margin-top'    => 0,
            'margin-right'  => 0,
            'margin-bottom' => 0,
            'margin-left'   => 0,

            'disable-smart-shrinking',
        ];
        $pdf = new Pdf($options);
        $pdf->addPage($view);
        $pdf->saveAs($filePath);

        return $filePath;
    }
}
