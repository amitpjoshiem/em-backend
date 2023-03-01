<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas;

use App\Containers\AppSection\AssetsIncome\Data\Enums\GroupsEnum;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\RowAdditionsDataTransporter;
use Illuminate\Support\Collection;

class GroupSchema
{
    public string $title;

    public Collection $rows;

    public function __construct(public string $name, array $rows, public array $headers, bool $married)
    {
        $this->title = GroupsEnum::getLabel($this->name);

        $this->rows = collect();
        foreach ($rows as $rowName => $rowItems) {
            $rowSchema = new RowSchema($rowItems, $rowName, $this);
            $rowSchema->setMarried($married);
            $this->rows->put($rowName, $rowSchema);
        }
    }

    public function hasRow(string $row): bool
    {
        return $this->rows->has($row);
    }

    public function addRow(array $rowItems, string $name, ?RowSchema $afterRow = null, ?RowAdditionsDataTransporter $data = null): RowSchema
    {
        $row = new RowSchema($rowItems, $name, $this, $data);

        if ($afterRow !== null) {
            $index = $this->getRowIndex($afterRow);

            if ($index !== null) {
                $this->rows->splice($index + 1, 0, [$row]);
            }
        } else {
            $this->rows->put($name, $row);
        }

        return $row;
    }

    public function findRow(string $name): RowSchema
    {
        return $this->rows->get($name);
    }

    private function getRowIndex(RowSchema $basicRow): ?int
    {
        $index = 0;
        /** @var RowSchema $row */
        foreach ($this->rows as $row) {
            if ($row->name === $basicRow->name) {
                return $index;
            }

            $index++;
        }

        return null;
    }
}
