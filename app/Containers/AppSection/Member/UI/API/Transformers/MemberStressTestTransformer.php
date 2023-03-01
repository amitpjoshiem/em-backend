<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Transformers\Transformer;
use Carbon\Carbon;

class MemberStressTestTransformer extends Transformer
{
    public function transform(Media $stressTest): array
    {
        $linkExpire = Carbon::now()->addMinutes(config('appSection-member.stress_test_link_expire_minutes'));

        return [
            'id'            => $stressTest->getHashedKey(),
            'name'          => $stressTest->file_name,
            'url'           => $this->getUrl($stressTest, $linkExpire),
            'extension'     => $stressTest->extension,
            'link_expire'   => $linkExpire->toDateTimeString(),
            'created_at'    => $stressTest->created_at?->toDateTimeString(),
        ];
    }
}
