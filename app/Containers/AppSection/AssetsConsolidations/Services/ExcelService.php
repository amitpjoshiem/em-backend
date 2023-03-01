<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Services;

use App\Containers\AppSection\AssetsConsolidations\Services\Support\ActiveArea;
use App\Containers\AppSection\AssetsConsolidations\Services\Support\Cell;
use PhpOffice\PhpSpreadsheet\Cell\Cell as SpreadSheetCell;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Helper\Dimension;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator;
use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

class ExcelService
{
    public Worksheet $worksheet;

    public ActiveArea $activeArea;

    private RowIterator $rowIterator;

    public function __construct(
        public Spreadsheet $spreadsheet,
        protected XlsxReader $reader,
    ) {
        $this->setActiveSheet();
        $this->rowIterator = $this->worksheet->getRowIterator();
    }

    public function load(string $filePath): static
    {
        $this->spreadsheet = $this->reader->load($filePath);

        return $this;
    }

    public function getActiveSheet(): Worksheet
    {
        return $this->spreadsheet->getActiveSheet();
    }

    public function setActiveSheet(?string $name = null): void
    {
        if ($name === null) {
            $this->worksheet = $this->getActiveSheet();

            return;
        }

        $worksheet = $this->getSheetByName($name);

        if ($worksheet === null) {
            throw new Exception();
        }

        $this->worksheet = $worksheet;
    }

    public function getSheetByName(string $name): ?Worksheet
    {
        return $this->spreadsheet->getSheetByCodeName($name);
    }

    public function setSheetTitle(string $title): void
    {
        $this->worksheet->setTitle($title);
    }

    public function getCell(string $column, int $row): Cell
    {
        return new Cell($column, $row);
    }

    public function setActiveArea(Cell $start, Cell $end): void
    {
        $this->activeArea = new ActiveArea($start, $end);
    }

    public function mergeActiveArea(): void
    {
        $this->worksheet->mergeCells($this->activeArea->getRange());
    }

    public function setActiveAreaBackgroundColor(string $color): void
    {
        $this->worksheet->getStyle($this->activeArea->getRange())
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($color);
    }

    /**
     * @throws Exception
     */
    public function fillActiveAreaFromArray(array $data): void
    {
        $this->activeArea->checkFilledDataCount($data);

        $this->worksheet->fromArray($data, startCell: $this->activeArea->getStartCoordinate());
    }

    /**
     * @throws Exception
     */
    public function setBackgroundColorToCell(Cell $cell, ?string $color): void
    {
        $this->worksheet->getStyle($cell->getCoordinate())
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($color);
    }

    /**
     * @throws Exception
     */
    public function setHorizontalAlignmentToCell(Cell $cell, string $alignment): void
    {
        $this->worksheet->getStyle($cell->getCoordinate())
            ->getAlignment()
            ->setHorizontal($alignment);
    }

    /**
     * @throws Exception
     */
    public function setVerticalAlignmentToCell(Cell $cell, string $alignment): void
    {
        $this->worksheet->getStyle($cell->getCoordinate())
            ->getAlignment()
            ->setVertical($alignment);
    }

    public function setWidthToColumn(string $column, float $width, string $type = Dimension::UOM_PIXELS): void
    {
        $this->worksheet->getColumnDimension($column)->setWidth($width, $type);
    }

    public function setActiveAreaAutoSize(): void
    {
        $areaIterator = $this->activeArea->getAreaCellIterator($this->rowIterator);
        /** @var SpreadSheetCell $cell */
        foreach ($areaIterator as $cell) {
            $this->worksheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
        }
    }

    public function nextRow(): void
    {
        $this->rowIterator->next();
    }

    public function getCurrentRowIndex(): int
    {
        return $this->rowIterator->key();
    }

    public function setRow(int $rowIndex = 1): void
    {
        $this->rowIterator->resetStart($rowIndex);
    }

    public function setRowHeight(int $rowIndex, float $height, ?string $unit = null): void
    {
        $this->worksheet->getRowDimension($rowIndex)->setRowHeight($height, $unit);
    }

    public function setValueToCell(Cell $cell, mixed $value): void
    {
        $this->worksheet->setCellValue($cell->getCoordinate(), $value);
    }

    public function setFontColorToCell(Cell $cell, string $color): void
    {
        $this->worksheet->getCell($cell->getCoordinate())
            ->getStyle()
            ->getFont()
            ->getColor()
            ->setRGB($color);
    }

    public function setStyleToActiveArea(array $styleConfig): void
    {
        $this->worksheet->getStyle($this->activeArea->getRange())->applyFromArray($styleConfig);
    }

    public function getAreaCellIterator(): RowCellIterator
    {
        return $this->activeArea->getAreaCellIterator($this->rowIterator);
    }

    public function setHorizontalAlignmentToActiveArea(string $alignment): void
    {
        $this->worksheet->getStyle($this->activeArea->getRange())
            ->getAlignment()
            ->setHorizontal($alignment);
    }

    public function setVerticalAlignmentToActiveArea(string $alignment): void
    {
        $this->worksheet->getStyle($this->activeArea->getRange())
            ->getAlignment()
            ->setVertical($alignment);
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function save(string $filePath): void
    {
        $writer = new XlsxWriter($this->spreadsheet);
        $writer->save($filePath);
    }

    public function fillMergedRow(string $column1, string $column2, int $row, array $data): void
    {
        $this->setActiveArea(
            $this->getCell($column1, $row),
            $this->getCell($column2, $row),
        );

        $this->mergeActiveArea();
        $this->fillActiveAreaFromArray($data);
    }

    public function wrapTextActiveArea(): void
    {
        $this->worksheet->getStyle($this->activeArea->getRange())
            ->getAlignment()
            ->setWrapText(true);
    }

    public function setPageOrientation(string $orientation): void
    {
        $this->worksheet->getPageSetup()->setOrientation($orientation);
    }

    public function setFontSizeToActiveArea(float $size): void
    {
        $this->worksheet->getStyle($this->activeArea->getRange())
            ->getFont()->setSize($size);
    }
}
