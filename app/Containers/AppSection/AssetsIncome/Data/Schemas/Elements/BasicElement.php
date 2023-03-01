<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements;

use App\Containers\AppSection\AssetsIncome\Data\Schemas\RowSchema;
use Illuminate\Support\Str;

abstract class BasicElement
{
    public string $label;

    public bool $disabled = false;

    public bool $calculated = false;

    public function __construct(public string $name, public RowSchema $row)
    {
        $this->label = str_replace('_', ' ', Str::title($this->name));
    }

    abstract public function getType(): string;

    public function getModel(): array
    {
        return [
            'group' => $this->row->group->name,
            'model' => $this->row->name,
            'item'  => $this->name,
        ];
    }

    public function setDisabled(bool $disabled): void
    {
        $this->disabled = $disabled;
    }

    public function setCalculated(bool $calculated): void
    {
        $this->calculated = $calculated;
    }

    public static function hasDefaultValue(): bool
    {
        return false;
    }
}
