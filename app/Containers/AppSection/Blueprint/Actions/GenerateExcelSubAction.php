<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\AssetsConsolidations\Services\ExcelService;
use App\Containers\AppSection\Blueprint\Data\Transporters\OutputBlueprintMonthlyIncomeTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Containers\AppSection\Blueprint\Models\BlueprintNetworth;
use App\Containers\AppSection\Blueprint\Tasks\CalculateBlueprintNetWorthPercentageTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Actions\SubAction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class GenerateExcelSubAction extends SubAction
{
    public function __construct(protected ExcelService $excelService)
    {
    }

    public function run(BlueprintDoc $doc): string
    {
        /** @var BlueprintNetworth $netWorth */
        $netWorth = app(GetBlueprintNetWorthSubAction::class)->run($doc->member->getKey());
        /** @var OutputBlueprintMonthlyIncomeTransporter $monthlyIncome */
        $monthlyIncome = app(GetBlueprintMonthlyIncomeSubAction::class)->run($doc->member->getKey());
        /** @var BlueprintConcern $concern */
        $concern = app(GetBlueprintConcernSubAction::class)->run($doc->member->getKey());
        $this->excelService->setActiveSheet();
        $this->excelService->setSheetTitle('Final SWR');
        $this->setHeader($doc->member);
        $this->setNetWorth($netWorth);
        $this->setMonthlyIncome($monthlyIncome);
        $this->setConcern($concern);
        $this->setNotes($doc->member->notes ?? '');

        /** @psalm-suppress UndefinedInterfaceMethod */
        $tempPath  = Storage::disk('temp')->getDriver()->getAdapter()->getPathPrefix();
        $file_path = $tempPath . $doc->filename;
        $this->excelService->save($file_path);

        return $file_path;
    }

    private function setHeader(Member $member): void
    {
        $this->excelService->fillMergedRow('F', 'I', 2, [$member->name]);
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_CENTER);
        $this->excelService->fillMergedRow('F', 'I', 3, ['Blueprint report ' . Carbon::now()->year]);
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_CENTER);
    }

    private function setNetWorth(BlueprintNetworth $netWorth): void
    {
        $this->excelService->fillMergedRow('B', 'C', 5, ['Net Worth']);

        $netWorth = app(CalculateBlueprintNetWorthPercentageTask::class)->run($netWorth);

        $this->excelService->setRow(5);
        $this->excelService->nextRow();
        foreach ($netWorth as $field => $sum) {
            $this->excelService->nextRow();
            $row = $this->excelService->getCurrentRowIndex();

            if (\is_array($sum)) {
                $this->excelService->fillMergedRow('B', 'C', $row, [Str::title($field)]);
                $this->excelService->fillMergedRow('D', 'E', $row, ['$ ' . number_format($sum['amount'], 3)]);
                $this->excelService->fillMergedRow('F', 'G', $row, [$sum['percentage'] . '%']);
            } else {
                $this->excelService->fillMergedRow('B', 'C', $row, ['Total']);
                $this->excelService->fillMergedRow('D', 'E', $row, ['$ ' . number_format($sum, 3)]);
            }
        }

        /** Set Styles */
        $this->excelService->setActiveArea(
            $this->excelService->getCell('B', 5),
            $this->excelService->getCell('G', $this->excelService->getCurrentRowIndex()),
        );
        $style = [
            'borders' => [
                'outline' => [
                    'borderStyle'   => Border::BORDER_THIN,
                    'color'         => ['rgb', '000000'],
                ],
            ],
        ];
        $this->excelService->setStyleToActiveArea($style);
    }

    private function setMonthlyIncome(OutputBlueprintMonthlyIncomeTransporter $monthlyIncome): void
    {
        $this->excelService->fillMergedRow('H', 'M', 5, ['Monthly Income Analysis']);
        $this->excelService->setActiveAreaBackgroundColor('C8D4D8');
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_CENTER);
        $this->excelService->setRow(6);

        $row = $this->excelService->getCurrentRowIndex();
        $this->excelService->fillMergedRow('J', 'K', $row, ['Current']);
        $this->excelService->fillMergedRow('L', 'M', $row, ['Future']);

        $fields = [
            'member',
            'spouse',
            'pensions',
            'rental_income',
            'investment',
        ];
        foreach ($fields as $field) {
            $this->excelService->nextRow();
            $row = $this->excelService->getCurrentRowIndex();
            $this->excelService->fillMergedRow('H', 'I', $row, [Str::title($field)]);
            $this->excelService->fillMergedRow('J', 'K', $row, ['$ ' . number_format($monthlyIncome->{'current_' . $field} ?? 0, 3)]);
            $this->excelService->fillMergedRow('L', 'M', $row, ['$ ' . number_format($monthlyIncome->{'future_' . $field} ?? 0, 3)]);
        }

        $fields = [
            'total',
            'tax',
            'ira_first',
            'ira_second',
            'monthly_expenses',
        ];
        foreach ($fields as $field) {
            $this->excelService->nextRow();
            $row = $this->excelService->getCurrentRowIndex();
            $this->excelService->fillMergedRow('H', 'I', $row, [Str::title($field)]);
            $this->excelService->fillMergedRow('L', 'M', $row, ['$ ' . number_format($monthlyIncome->{$field} ?? 0, 3)]);

            if ($field === 'total') {
                $this->excelService->setActiveArea(
                    $this->excelService->getCell('H', $row),
                    $this->excelService->getCell('M', $row),
                );
                $this->excelService->setActiveAreaBackgroundColor('C8D4D8');
            }
        }

        $this->excelService->setActiveArea(
            $this->excelService->getCell('H', $this->excelService->getCurrentRowIndex()),
            $this->excelService->getCell('M', $this->excelService->getCurrentRowIndex()),
        );
        $this->excelService->setActiveAreaBackgroundColor('91D0E5');
        /** Set Styles */
        $this->excelService->setActiveArea(
            $this->excelService->getCell('H', 5),
            $this->excelService->getCell('M', $this->excelService->getCurrentRowIndex()),
        );
        $style = [
            'borders' => [
                'outline' => [
                    'borderStyle'   => Border::BORDER_THIN,
                    'color'         => ['rgb', '000000'],
                ],

                'horizontal'    => [
                    'borderStyle'   => Border::BORDER_THIN,
                    'color'         => ['rgb', '000000'],
                ],
            ],
        ];
        $this->excelService->setStyleToActiveArea($style);
    }

    private function setConcern(BlueprintConcern $concern): void
    {
        $this->excelService->fillMergedRow('B', 'C', 12, ['Concerns']);

        $fields = $concern->only([
            'high_fees',
            'extremely_high_market_exposure',
            'simple',
            'keep_the_money_safe',
            'massive_overlap',
            'design_implement_monitoring_income_strategy',
        ]);
        $this->excelService->setRow(13);
        /**
         * @var string $field
         * @var bool   $data
         */
        foreach ($fields as $field => $data) {
            $this->excelService->nextRow();
            $row  = $this->excelService->getCurrentRowIndex();
            $cell = $this->excelService->getCell('B', $row);

            if ($data) {
                $this->excelService->setValueToCell($cell, 'X');
                $this->excelService->setBackgroundColorToCell($cell, '7AE186');
                $this->excelService->setHorizontalAlignmentToCell($cell, Alignment::HORIZONTAL_CENTER);
            } else {
                $this->excelService->setBackgroundColorToCell($cell, 'E57878');
            }

            $this->excelService->fillMergedRow('C', 'G', $row, [Str::title($field)]);
        }

        /** Set Styles */
        $this->excelService->setActiveArea(
            $this->excelService->getCell('B', 12),
            $this->excelService->getCell('G', $this->excelService->getCurrentRowIndex()),
        );
        $style = [
            'borders' => [
                'outline' => [
                    'borderStyle'   => Border::BORDER_THIN,
                    'color'         => ['rgb', '000000'],
                ],
            ],
        ];
        $this->excelService->setStyleToActiveArea($style);
        $this->excelService->setWidthToColumn('B', 0.6, 'cm');
        $this->excelService->setWidthToColumn('C', 2.3, 'cm');
    }

    private function setNotes(string $notes): void
    {
        $this->excelService->fillMergedRow('B', 'C', 21, ['Notes']);
        $this->excelService->setActiveArea(
            $this->excelService->getCell('B', 22),
            $this->excelService->getCell('G', 26),
        );
        $this->excelService->mergeActiveArea();
        $this->excelService->fillActiveAreaFromArray([$notes]);
        $this->excelService->wrapTextActiveArea();
        $this->excelService->setVerticalAlignmentToActiveArea(Alignment::VERTICAL_TOP);
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_LEFT);
    }
}
