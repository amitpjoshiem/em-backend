<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\SubActions;

use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\BasicElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\NumberElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\StringElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\TotalElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\GroupSchema;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\GetSchemaTransporter;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\RowAdditionsDataTransporter;
use App\Containers\AppSection\AssetsIncome\Models\AssetsIncomeValue;
use App\Containers\AppSection\AssetsIncome\Tasks\FindRowInDropdownOptionTask;
use App\Containers\AppSection\AssetsIncome\Tasks\GetAllValuesTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class GetSchemaSubAction extends SubAction
{
    public function run(int $memberId): SupportCollection
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($memberId);
        $schema = config('appSection-assetsIncome.schema');
        $groups = collect();
        foreach ($schema['groups'] as $title => $group) {
            $headers = $schema['headers'][$title];

            if (\in_array('spouse', $headers, true) && !$member->married) {
                $pos = array_search('spouse', $headers, true);
                unset($headers[$pos]);
            }

            $formattedHeaders = [];
            foreach ($headers as $header) {
                if ($header === 'owner') {
                    $formattedHeaders[$header]['label'] = $member->name;
                } elseif ($header === 'spouse') {
                    $formattedHeaders[$header]['label'] = $member->spouse?->getName();
                } else {
                    $formattedHeaders[$header]['label'] = ucfirst($header);
                }
            }

            $groups->put($title, new GroupSchema($title, $group, $formattedHeaders, $member->married));
        }

        /** @var Collection $values */
        $values        = app(GetAllValuesTask::class)->filterByMember($member->getKey())->run();
        $groupedValues = $values->groupBy('group');
        /** @var Collection $group */
        foreach ($groupedValues as $groupName => $group) {
            /** @var GroupSchema $groupSchema */
            $groupSchema = $groups[$groupName];
            $rows        = $group->groupBy('row');
            /** @var Collection $row */
            foreach ($rows as $rowName => $row) {
                $rowName = (string)$rowName;

                if (!$groupSchema->hasRow($rowName)) {
                    $rowItems = array_fill_keys($schema['headers'][$groupName], NumberElement::class);

                    if (isset($rowItems['institution'])) {
                        $rowItems['institution'] = StringElement::class;
                    }

                    if ($row->first()?->parent !== null) {
                        $dropdown = $row->first()?->parent;
                    } else {
                        /** @var string | null $dropdown */
                        $dropdown = app(FindRowInDropdownOptionTask::class)->run($rowName);
                    }

                    if ($dropdown !== null) {
                        $dropdownItem = $groupSchema->findRow($dropdown);
                    }

                    $additionData = new RowAdditionsDataTransporter([
                        'joined'    => $this->isRowJoined($row),
                        'can_join'  => $this->isRowCanJoin($row),
                        'married'   => $member->married,
                    ]);

                    $rowSchema = $groupSchema->addRow($rowItems, $rowName, $dropdownItem ?? null, $additionData);
                    $rowSchema->setCustom(true);
                } else {
                    $groupSchema->findRow($rowName)->setJoined($this->isRowJoined($row));
                    $groupSchema->findRow($rowName)->setCanJoin($this->isRowCanJoin($row));
                    $groupSchema->findRow($rowName)->setMarried($member->married);
                }
            }
        }

        $groups->each(function (GroupSchema $group) use ($schema): void {
            $rowItems = array_fill_keys($schema['headers'][$group->name], TotalElement::class);

            if (isset($rowItems['institution'])) {
                $rowItems['institution'] = TotalElement::class;
            }

            $row = $group->addRow($rowItems, 'total');
            $row->elements->each(function (BasicElement $element): void {
                $element->setDisabled(true);
                $element->setCalculated(true);
            });
        });

        return $groups;
    }

    private function isRowJoined(Collection $items): bool
    {
        /** @var AssetsIncomeValue | null $owner */
        $owner = $items->filter(function (AssetsIncomeValue $item): bool {
            return $item->element === 'owner';
        })->first();

        return $owner?->joined ?? false;
    }

    private function isRowCanJoin(Collection $items): bool
    {
        /** @var AssetsIncomeValue | null $owner */
        $owner = $items->filter(function (AssetsIncomeValue $item): bool {
            return $item->element === 'owner';
        })->first();

        return $owner?->can_join ?? false;
    }
}
