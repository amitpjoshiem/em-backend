<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\AssetsConsolidations\Services\ExcelService;
use App\Containers\AppSection\AssetsConsolidations\Services\Support\Cell;
use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Helper\Dimension;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class GenerateClientReportExcelSubAction extends SubAction
{
    /**
     * @var string[]
     */
    private const ACTIVE_COLUMNS = [
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
    ];

    /**
     * @var array<string, string>
     */
    private const TABLE_COLUMNS = [
        'A' => 'Beginning Balance',
        'B' => 'Interested Credited',
        'C' => 'Growth',
        'D' => 'Withdrawals',
        'E' => 'Contract value',
        'F' => 'Total Premiums',
        'G' => 'Bonus Received (if applicable)',
        'H' => 'Interested Credited',
        'I' => 'Total Withdrawals',
        'J' => 'Average Growth',
    ];

    public function __construct(protected ExcelService $excelService)
    {
    }

    public function run(ClientReportsDoc $doc): string
    {
        $this->excelService->setPageOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $this->setColumnsWidth();
        $this->setHeader($doc->member->name);
        /** @var ClientReport $contrac */
        foreach ($doc->contracts as $contract) {
            $this->excelService->nextRow();
            $this->setTable($contract);
        }

        $this->setFooter();
        /** @psalm-suppress UndefinedInterfaceMethod */
        $tempPath  = Storage::disk('temp')->getDriver()->getAdapter()->getPathPrefix();
        $file_path = $tempPath . $doc->filename;
        $this->excelService->save($file_path);

        return $file_path;
    }

    private function setColumnsWidth(): void
    {
        foreach (self::ACTIVE_COLUMNS as $column) {
            $this->excelService->setWidthToColumn($column, 2.25, Dimension::UOM_CENTIMETERS);
        }
    }

    private function setHeader(string $name): void
    {
        $row = $this->excelService->getCurrentRowIndex();
        $this->excelService->fillMergedRow('E', 'F', $row, [$name]);
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_CENTER);
        $this->excelService->nextRow();

        $row = $this->excelService->getCurrentRowIndex();
        $this->excelService->fillMergedRow('E', 'F', $row, ['Progress Report ' . Carbon::now()->year]);
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_CENTER);
    }

    private function setTable(ClientReport $report): void
    {
        $this->excelService->nextRow();
        $this->setTableHeader($report);
        $this->excelService->nextRow();
        $this->setTableBody($report);
        $this->excelService->nextRow();
        $this->setTableTotal($report);
    }

    private function setTableHeader(ClientReport $report): void
    {
        $row = $this->excelService->getCurrentRowIndex();
        $this->excelService->fillMergedRow('A', 'C', $row, ['Registration: ' . ($report->carrier ?? '')]);
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_LEFT);
        $this->excelService->nextRow();

        $row = $this->excelService->getCurrentRowIndex();
        $this->excelService->fillMergedRow('A', 'B', $row, ['Contract: #' . $report->contract_number]);
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_LEFT);
        $this->excelService->fillMergedRow('E', 'F', $row, ['Issue/Anniversary Date:' . ($report->formatted_origination_date ?? '')]);
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_CENTER);
        $this->excelService->fillMergedRow('I', 'J', $row, ['Contract Years: ' . ($report->contract_years ?? '')]);
        $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_RIGHT);
    }

    private function setTableBody(ClientReport $report): void
    {
        $row      = $this->excelService->getCurrentRowIndex();
        $startRow = $row;
        $this->excelService->fillMergedRow('A', 'E', $row, ['Current Year']);
        $this->excelService->setActiveAreaBackgroundColor('95B3D7');
        $this->excelService->fillMergedRow('F', 'J', $row, ['Since Inception']);
        $this->excelService->setActiveAreaBackgroundColor('C3D69B');
        $this->excelService->nextRow();

        $row = $this->excelService->getCurrentRowIndex();
        $this->excelService->setRowHeight($row, 1, Dimension::UOM_CENTIMETERS);
        $this->excelService->setActiveArea(
            $this->excelService->getCell('A', $row),
            $this->excelService->getCell('J', $row),
        );
        $this->excelService->wrapTextActiveArea();
        foreach (self::TABLE_COLUMNS as $column => $field) {
            $this->setTableBodyCell(
                $this->excelService->getCell($column, $row),
                $field,
                Alignment::VERTICAL_CENTER,
                Alignment::HORIZONTAL_CENTER,
            );
        }

        $this->excelService->setActiveArea(
            $this->excelService->getCell('A', $row),
            $this->excelService->getCell('E', $row),
        );
        $this->excelService->setActiveAreaBackgroundColor('95B3D7');
        $this->excelService->setActiveArea(
            $this->excelService->getCell('F', $row),
            $this->excelService->getCell('J', $row),
        );
        $this->excelService->setActiveAreaBackgroundColor('C3D69B');
        $this->excelService->nextRow();

        $row = $this->excelService->getCurrentRowIndex();
        $this->excelService->setValueToCell($this->excelService->getCell('A', $row), $report->origination_value);
        $this->excelService->setValueToCell($this->excelService->getCell('E', $row), $report->current_value);
        $this->excelService->setActiveArea(
            $this->excelService->getCell('A', $startRow),
            $this->excelService->getCell('J', $row),
        );
        $style = [
            'borders' => [
                'outline' => [
                    'borderStyle'   => Border::BORDER_THIN,
                    'color'         => ['rgb', '000000'],
                ],
                'inside'    => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $this->excelService->setStyleToActiveArea($style);
    }

    /**
     * @throws Exception
     */
    private function setTableBodyCell(Cell $cell, string $data, string $verticalAlignment, string $horizontalAlignment): void
    {
        $this->excelService->setValueToCell($cell, $data);
        $this->excelService->setHorizontalAlignmentToCell($cell, $horizontalAlignment);
        $this->excelService->setVerticalAlignmentToCell($cell, $verticalAlignment);
    }

    public function setTableTotal(ClientReport $report): void
    {
        $row = $this->excelService->getCurrentRowIndex();
        $this->excelService->setValueToCell($this->excelService->getCell('A', $row), 'Total Fees:');
        $this->excelService->setValueToCell($this->excelService->getCell('B', $row), '-');
    }

    private function setFooter(): void
    {
        $this->excelService->nextRow();
        $startRow = $this->excelService->getCurrentRowIndex();
        $this->excelService->fillMergedRow('H', 'I', $this->excelService->getCurrentRowIndex(), ['TDA Total Value']);
        $this->excelService->nextRow();
        $this->excelService->fillMergedRow('H', 'I', $this->excelService->getCurrentRowIndex(), ['Total Current Value']);
        $this->excelService->setActiveArea(
            $this->excelService->getCell('H', $startRow),
            $this->excelService->getCell('J', $this->excelService->getCurrentRowIndex()),
        );
        $style = [
            'borders' => [
                'outline' => [
                    'borderStyle'   => Border::BORDER_THICK,
                    'color'         => ['rgb', '000000'],
                ],
                'inside'    => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $this->excelService->setStyleToActiveArea($style);
    }
}
