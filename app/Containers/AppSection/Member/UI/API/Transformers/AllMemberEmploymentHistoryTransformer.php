<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use App\Ship\Parents\Transformers\Transformer;
use Illuminate\Support\Collection;

class AllMemberEmploymentHistoryTransformer extends Transformer
{
    public function transform(object $history): array
    {
        $data = [
            'member' => $this->transformHistory($history->member),
        ];

        if (property_exists($history, 'spouse')) {
            $data['spouse'] = $this->transformHistory($history->spouse);
        }

        return $data;
    }

    private function transformHistory(Collection $history): array
    {
        $data = [];
        /** @var MemberEmploymentHistory $item */
        foreach ($history->sortByDesc('updated_at') as $item) {
            $data[] = [
                'id'            => $item->getHashedKey(),
                'company_name'  => $item->company_name,
                'occupation'    => $item->occupation,
                'years'         => $item->years,
            ];
        }

        return $data;
    }
}
