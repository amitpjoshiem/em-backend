<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\OutputAssetsConsolidationsTableTransporter;
use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\OutputAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Services\ExcelService;
use App\Containers\AppSection\AssetsConsolidations\Services\Support\Cell as SupportCell;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class GenerateExcelExportAction extends Action
{
    private array $tableConfigs;

    private array $totalRows;

    public function __construct(protected ExcelService $excelService)
    {
    }

    public function run(int $exportId, int $memberId, string $filename): string
    {
        $this->tableConfigs = config('appSection-assetsConsolidations.export.excel');
        /** @var Collection $assetsConsolidations */
        $assetsConsolidations = app(GetAllCalculatedAssetsConsolidationsSubAction::class)->run($memberId);
        $tablesData           = $assetsConsolidations->filter(function (OutputAssetsConsolidationsTableTransporter $table): bool {
            return $table->tableHashId !== 'total';
        });
        $this->excelService->setActiveSheet();
        $this->excelService->setSheetTitle('Final SWR');

        /** @var OutputAssetsConsolidationsTableTransporter $tableData */
        foreach ($tablesData as $tableData) {
            $tableData = $tableData->tableData->filter(fn (OutputAssetsConsolidationsTransporter $row): bool => $row->name !== 'total')
                ->sortBy('id');
            $this->createTable($tableData);
            $this->excelService->nextRow();
        }

        $this->createSubmitTable();

        /** @psalm-suppress UndefinedInterfaceMethod */
        $tempPath  = Storage::disk('temp')->getDriver()->getAdapter()->getPathPrefix();
        $file_path = $tempPath . $filename;
        $this->excelService->save($file_path);

        return $file_path;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function createTable(Collection $tableData): void
    {
        /** @var OutputAssetsConsolidationsTransporter $tableFirstRow */
        $tableFirstRow = $tableData->first();
        /** @var array $table */
        $table         = $tableFirstRow->table;
        $tableName     = $table['name'];
        $firstTableRow = $this->excelService->getCurrentRowIndex();
        $this->setHeader($tableName);
        [$startRow, $endRow]                                    = $this->setData($tableData);
        $this->totalRows[$this->setTotal($startRow, $endRow)]   = $tableName;
        $lastTableRow                                           = $this->excelService->getCurrentRowIndex();
        $this->setFooter();
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
        $this->excelService->setActiveArea(
            $this->excelService->getCell('A', $firstTableRow),
            $this->excelService->getCell('I', $lastTableRow),
        );
        $this->excelService->setStyleToActiveArea($style);
        $this->excelService->nextRow();
    }

    private function setData(Collection $tableData): array
    {
        $startRow = $this->excelService->getCurrentRowIndex() + 1;
        $totalRow = \count($tableData)                        + $startRow;
        /** @var OutputAssetsConsolidationsTransporter $row */
        foreach ($tableData as $row) {
            $this->excelService->nextRow();
            $rowIndex             = $this->excelService->getCurrentRowIndex();
            $holdingsFormula      = sprintf('=C%s/C%s', $rowIndex, $totalRow);
            $totalFormula         = sprintf('=(D%1$s*C%1$s)+(G%1$s*C%1$s)+((E%1$s*C%1$s)*F%1$s)', $rowIndex);
            $totalPercentFormula  = sprintf('=I%1$s/C%1$s', $rowIndex);
            $this->excelService->setActiveArea(
                $this->excelService->getCell('A', $rowIndex),
                $this->excelService->getCell('I', $rowIndex),
            );
            $this->excelService->fillActiveAreaFromArray([
                $row->name,
                $holdingsFormula,
                $row->amount,
                $row->management_expense,
                $row->turnover,
                $row->trading_cost,
                $row->wrap_fee,
                $totalPercentFormula,
                $totalFormula,
            ]);
        }

        return [$startRow, $this->excelService->getCurrentRowIndex()];
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function setHeader(?string $headText = null): void
    {
        $header   = $this->tableConfigs['table_header'];
        $rowIndex = $this->excelService->getCurrentRowIndex();
        /** @var string $firstHeader */
        $firstHeader = array_key_first($header);
        /** @var string $lastHeader */
        $lastHeader = array_key_last($header);
        $this->excelService->setActiveArea(
            $this->excelService->getCell($firstHeader, $rowIndex),
            $this->excelService->getCell($lastHeader, $rowIndex),
        );
        $this->excelService->mergeActiveArea();

        if ($headText !== null) {
            $this->excelService->setHorizontalAlignmentToActiveArea(Alignment::HORIZONTAL_CENTER);
            $this->excelService->fillActiveAreaFromArray([$headText]);
        }

        $this->excelService->setActiveAreaBackgroundColor('38BAED');
        $this->excelService->nextRow();

        $rowIndex = $this->excelService->getCurrentRowIndex();
        $this->excelService->setActiveArea(
            $this->excelService->getCell($firstHeader, $rowIndex),
            $this->excelService->getCell($lastHeader, $rowIndex),
        );
        $this->excelService->setActiveAreaBackgroundColor('38BAED');
        $this->excelService->fillActiveAreaFromArray(array_values($header));
        $this->excelService->setActiveAreaAutoSize();
    }

    private function setTotal(int $startRow, int $endRow): int
    {
        $this->excelService->nextRow();
        $rowIndex = $this->excelService->getCurrentRowIndex();
        $this->excelService->setRowHeight($rowIndex, 30, 'px');
        $this->excelService->setActiveArea(
            $this->excelService->getCell('A', $rowIndex),
            $this->excelService->getCell('I', $rowIndex),
        );
        $this->excelService->fillActiveAreaFromArray([
            'Total',
            sprintf('=SUM(B%d:B%d)', $startRow, $endRow),
            sprintf('=SUM(C%d:C%d)', $startRow, $endRow),
            sprintf('=AVERAGE(D%d:D%d)', $startRow, $endRow),
            sprintf('=AVERAGE(E%d:E%d)', $startRow, $endRow),
            sprintf('=AVERAGE(F%d:F%d)', $startRow, $endRow),
            sprintf('=AVERAGE(G%d:G%d)', $startRow, $endRow),
            sprintf('=I%d/C%d', $rowIndex, $rowIndex),
            sprintf('=SUM(I%d:I%d)', $startRow, $endRow),
        ]);
        $this->excelService->setBackgroundColorToCell(
            $this->excelService->getCell('C', $rowIndex),
            '2BE114'
        );
        $this->excelService->setActiveArea(
            $this->excelService->getCell('D', $rowIndex),
            $this->excelService->getCell('H', $rowIndex),
        );
        $this->excelService->setActiveAreaBackgroundColor('E4EE14');
        $this->excelService->setBackgroundColorToCell(
            $this->excelService->getCell('I', $rowIndex),
            'EE3F14'
        );

        return $this->excelService->getCurrentRowIndex();
    }

    private function setFooter(): void
    {
        $header = $this->tableConfigs['table_header'];
        $this->excelService->nextRow();
        $rowIndex = $this->excelService->getCurrentRowIndex();
        /** @var string $firstHeader */
        $firstHeader = array_key_first($header);
        /** @var string $lastHeader */
        $lastHeader = array_key_last($header);
        $this->excelService->setActiveArea(
            $this->excelService->getCell($firstHeader, $rowIndex),
            $this->excelService->getCell($lastHeader, $rowIndex),
        );
        $this->excelService->mergeActiveArea();

        $firstFooterCell = $this->excelService->getCell('A', $rowIndex);
        $this->excelService->setValueToCell($firstFooterCell, $this->tableConfigs['footer_text'][0]);
        $this->excelService->setFontColorToCell($firstFooterCell, 'FF0000');
        $this->excelService->nextRow();

        $rowIndex = $this->excelService->getCurrentRowIndex();
        $this->excelService->setActiveArea(
            $this->excelService->getCell($firstHeader, $rowIndex),
            $this->excelService->getCell($lastHeader, $rowIndex),
        );
        $this->excelService->mergeActiveArea();

        $secondFooterCell = $this->excelService->getCell('A', $rowIndex);
        $this->excelService->setValueToCell($secondFooterCell, $this->tableConfigs['footer_text'][1]);
        $this->excelService->setFontColorToCell($secondFooterCell, 'FF0000');
    }

    private function createSubmitTable(): void
    {
        $firstTableRow = $this->excelService->getCurrentRowIndex();
        $this->setHeader('Summary of Mutual Funds');
        [$startRow, $endRow] = $this->setSubmitData();
        $this->setTotal($startRow, $endRow);
        $lastTableRow = $this->excelService->getCurrentRowIndex();
        $this->setFooter();
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
        $this->excelService->setActiveArea(
            $this->excelService->getCell('A', $firstTableRow),
            $this->excelService->getCell('I', $lastTableRow),
        );
        $this->excelService->setStyleToActiveArea($style);
        $this->excelService->nextRow();
    }

    private function setSubmitData(): array
    {
        $startRow = $this->excelService->getCurrentRowIndex() + 1;
        $totalRow = \count($this->totalRows)                  + $startRow;
        foreach ($this->totalRows as $totalRowIndex => $tableName) {
            $this->excelService->nextRow();
            $currentRowIndex = $this->excelService->getCurrentRowIndex();
            $this->excelService->setActiveArea(
                $this->excelService->getCell('A', $currentRowIndex),
                $this->excelService->getCell('I', $currentRowIndex),
            );
            /** @var Cell $cell */
            foreach ($this->excelService->getAreaCellIterator() as $cell) {
                if ($cell->getColumn() === 'A') {
                    /** @var SupportCell $cell */
                    $cell = $this->excelService->getCell($cell->getColumn(), $currentRowIndex);
                    $this->excelService->setValueToCell($cell, $tableName);
                    continue;
                }

                $formula = sprintf('=%s%s', $cell->getColumn(), $totalRowIndex);

                if ($cell->getColumn() === 'B') {
                    $formula = sprintf('=%s%s/%s%s', 'C', $totalRowIndex, 'C', $totalRow);
                }

                /** @var SupportCell $cell */
                $cell = $this->excelService->getCell($cell->getColumn(), $currentRowIndex);
                $this->excelService->setValueToCell($cell, $formula);
            }
        }

        return [$startRow, $this->excelService->getCurrentRowIndex()];
    }
}
