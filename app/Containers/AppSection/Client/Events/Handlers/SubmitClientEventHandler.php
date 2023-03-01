<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Events\Handlers;

use App\Containers\AppSection\AssetsIncome\Data\Enums\GroupsEnum;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\RowSchema;
use App\Containers\AppSection\AssetsIncome\SubActions\GetSchemaSubAction;
use App\Containers\AppSection\AssetsIncome\SubActions\GetValuesSubAction;
use App\Containers\AppSection\Client\Events\Events\SubmitClientEvent;
use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Client\Tasks\FindClientByIdTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\UploadFileTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\MonthlyExpense\Actions\GetMonthlyExpensesAction;
use App\Containers\AppSection\MonthlyExpense\SubActions\GetMonthlyExpensesSubAction;
use App\Containers\AppSection\MonthlyExpense\UI\API\Transformers\MonthlyExpenseTransformer;
use App\Ship\Core\Traits\ResponseTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use mikehaertl\wkhtmlto\Pdf;

class SubmitClientEventHandler implements ShouldQueue
{
    use ResponseTrait;
    public function handle(SubmitClientEvent $event): void
    {
        /** @var Client $client */
        $client = app(FindClientByIdTask::class)
            ->withRelations(['member.spouse', 'member.employmentHistory', 'member.house', 'member.other'])
            ->run($event->clientId);
        $filePath = $this->createPdf($client->member);
//        app(UploadFileTask::class)
//            ->run($filePath, $this->getFileName($client->member), $client, MediaCollectionEnum::FINANCIAL_FACT_FINDER);
    }

    private function createPdf(Member $member)
    {
        $tmp = base_path('temp.pdf');
        if (file_exists($tmp)) {
            unlink($tmp);
        }
//        $tmp     = sprintf('%s/%s', config('appSection-client.pdf_report_tmp_path'), $this->getFileName($member));
        $pdf = new Pdf([
            'user-style-sheet' => [
                resource_path('assets/css/client/basic_info.css'),
                resource_path('assets/css/client/assets_income.css'),
            ],
            'run-script'       => [
                resource_path('assets/js/client/basic_info.js'),
                resource_path('assets/js/client/assets_income.js'),
            ],
            'no-outline',         // Make Chrome not complain
            'disable-smart-shrinking',
        ]);

        $schema = app(GetSchemaSubAction::class)->run($member->getKey());
        $values = app(GetValuesSubAction::class)->run($member->getKey());

        $expenses = app(GetMonthlyExpensesSubAction::class)->run($member->getKey());
        $pdf->addPage(view('appSection@client::base_pdf', [
            'member'    => $member,
            'assets_income' => [
                'schema' => $schema,
                'values' => $values,
            ],
            'expenses' => $this->transform($expenses, new MonthlyExpenseTransformer(), resourceKey: 'monthly_expenses'),
        ])->render());
        $pdf->saveAs($tmp);

        return $tmp;
    }

    private function getFileName(Member $member): string
    {
        $nameParts = Str::of($member->name)->explode(' ', 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];

        return match ($member->married) {
            true => sprintf(
                "%s, %s & %s, %s IRIS Financial Fact Finder %s.pdf",
                $lastName,
                $firstName,
                $member->spouse->last_name,
                $member->spouse->first_name,
                now()->format('m-d-Y'),
            ),
            false => sprintf(
                "%s, %s IRIS Financial Fact Finder %s.pdf",
                $lastName,
                $firstName,
                now()->format('m-d-Y'),
            ),
        };
    }
}
