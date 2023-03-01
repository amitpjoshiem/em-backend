<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas;

use App\Containers\AppSection\AssetsIncome\Data\Enums\GroupsEnum;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\DropdownElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\TotalElement;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\RowAdditionsDataTransporter;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RowSchema
{
    public Collection $elements;

    public string $label;

    public bool $custom = false;

    public bool $joined = false;

    private bool $canJoin = false;

    public bool $married = false;

    public function __construct(array | string $items, public string $name, public GroupSchema $group, ?RowAdditionsDataTransporter $data = null)
    {
        $this->elements = collect();
        $this->label    = $this->getTitle();
        $this->parseAdditionData($data);

        if (\is_array($items)) {
            foreach ($items as $name => $item) {
                if (\array_key_exists($name, $this->group->headers)) {
                    $this->elements->put($name, new $item($name, $this));
                }
            }

            if (\in_array($this->group->name, [GroupsEnum::LIQUID_ASSETS, GroupsEnum::OTHER_ASSETS_INVESTMENTS], true)) {
                $element = new TotalElement('household', $this);
                $element->setDisabled(true);
                $element->setCalculated(true);
                $this->elements->put('household', $element);
            }
        } else {
            /** @psalm-suppress InvalidStringClass */
            $this->elements->put($this->name, new $items($this->name, $this));
        }
    }

    public function setCustom(bool $isCustom): void
    {
        $this->custom = $isCustom;
    }

    public function setJoined(bool $joined): void
    {
        $this->joined = $joined;
    }

    public function getCanJoin(): bool
    {
        if (!$this->married) {
            return false;
        }

        return $this->canJoin;
    }

    public function setCanJoin(bool $canJoin): void
    {
        $this->canJoin = $canJoin || $this->canJoin || $this->canJoin();
    }

    private function getTitle(): string
    {
        $schema = config('appSection-assetsIncome.schema.dropdown_options');
        $labels = array_reduce($schema, 'array_merge', []);

        foreach (array_keys($labels) as $label) {
            if (str_contains($this->name, (string)$label)) {
                return ucwords(Str::replace('_', ' ', Str::replace($label, $labels[$label], $this->name)));
            }
        }

        return $labels[$this->name] ?? Str::title(str_replace('_', ' ', $this->name));
    }

    public function canJoin(): bool
    {
        $schema = config('appSection-assetsIncome.schema');

        return \in_array($this->name, $schema['joined_rows'][$this->group->name], true) ||
            \in_array($this->name, $schema['joined_dropdown'], true);
    }

    private function parseAdditionData(?RowAdditionsDataTransporter $data): void
    {
        $this->married = $data?->married ?? false;

        $this->canJoin = $this->canJoin();

        if ($data === null) {
            return;
        }

        $this->joined = $data->joined;

        $this->canJoin = $this->canJoin || $this->canJoin() || $data->can_join;
    }

    public function setMarried(bool $married): void
    {
        $this->married = $married;
    }

    public function isDropdown(): bool
    {
        return $this->elements->first() instanceof DropdownElement;
    }
}
