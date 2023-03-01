<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Services\Support;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator;
use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;

class ActiveArea
{
    public function __construct(protected Cell $startCell, protected Cell $endCell)
    {
    }

    public function getRange(): string
    {
        return sprintf(
            '%s:%s',
            $this->startCell->getCoordinate(),
            $this->endCell->getCoordinate(),
        );
    }

    /**
     * @throws Exception
     */
    public function checkFilledDataCount(array $data): void
    {
        $startIndex = $this->getStartColumnIndex();
        $endIndex   = $this->getEndColumnIndex();

        if (\count($data) > $endIndex - $startIndex + 1) {
            throw new Exception();
        }
    }

    public function getStartCoordinate(): string
    {
        return $this->startCell->getCoordinate();
    }

    public function getEndCoordinate(): string
    {
        return $this->endCell->getCoordinate();
    }

    /**
     * @throws Exception
     */
    public function getStartColumnIndex(): int
    {
        return $this->startCell->getColumnIndex();
    }

    /**
     * @throws Exception
     */
    public function getEndColumnIndex(): int
    {
        return $this->endCell->getColumnIndex();
    }

    public function getAreaCellIterator(RowIterator $rowIterator): RowCellIterator
    {
        return $rowIterator
            ->current()
            ->getCellIterator($this->startCell->getColumn(), $this->endCell->getColumn());
    }
}
