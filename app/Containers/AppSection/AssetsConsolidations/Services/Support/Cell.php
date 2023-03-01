<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Services\Support;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Exception;

class Cell
{
    public function __construct(protected string $column, protected int $row)
    {
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * @throws Exception
     */
    public function getColumnIndex(): int
    {
        return (int)Coordinate::columnIndexFromString($this->column);
    }

    public function getCoordinate(): string
    {
        return sprintf('%s%s', $this->column, $this->row);
    }
}
