<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\SubActions;

use App\Containers\AppSection\AssetsIncome\Data\Enums\GroupsEnum;
use App\Containers\AppSection\AssetsIncome\Models\AssetsIncomeValue;
use App\Containers\AppSection\AssetsIncome\Tasks\GetAllValuesTask;
use App\Containers\AppSection\AssetsIncome\Tasks\GetSchemaDefaultValuesTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class GetValuesSubAction extends SubAction
{
    public function run(int $memberId): stdClass
    {

        /** @var Collection $values */
        $values = app(GetAllValuesTask::class)->filterByMember($memberId)->run();
        /** @var Member $member */
        $member  = app(FindMemberByIdTask::class)->run($memberId);
        $result  = app(GetSchemaDefaultValuesTask::class)->run($member->married);
        $headers = config('appSection-assetsIncome.schema.headers');
        /** @var AssetsIncomeValue $value */
        foreach ($values as $value) {
            if (!isset($result[$value->group][$value->row])) {
                $spouseHeader = array_search('spouse', $headers[$value->group], true);

                if ($spouseHeader !== false && !$member->married) {
                    unset($headers[$value->group][$spouseHeader]);
                }

                /**
                 * @psalm-suppress InvalidPropertyFetch
                 */
                $result[$value->group][$value->row] = array_fill_keys($headers[$value->group], $value->type->value::DEFAULT_VALUE);
            }

            if ($value->element === 'institution') {
                $result[$value->group][$value->row][$value->element] = $value->value;
                continue;
            }

            $result[$value->group][$value->row][$value->element] = $value->value === null ? null : round((float)$value->value, 3);

            /** @psalm-suppress PossiblyNullOperand */
            $result[$value->group]['total'][$value->element] += (float)$value->value;
        }

        foreach ($result[GroupsEnum::LIQUID_ASSETS] as &$row) {
            $row['household'] = $row['owner'] + ($row['spouse'] ?? 0);
        }

        foreach ($result[GroupsEnum::OTHER_ASSETS_INVESTMENTS] as &$row) {
            $row['household'] = $row['owner'] + ($row['spouse'] ?? 0);
        }

        foreach ($result as $group) {
            /** @var float | null $value */
            foreach ($group['total'] as &$value) {
                if ($value !== null) {
                    $value = round($value, 3);
                }
            }
        }

        return (object)$result;
    }
}
