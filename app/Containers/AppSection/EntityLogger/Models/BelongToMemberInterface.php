<?php

declare(strict_types=1);

namespace App\Containers\AppSection\EntityLogger\Models;

use App\Containers\AppSection\Member\Models\Member;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Member $member
 */
interface BelongToMemberInterface
{
    public function member(): BelongsTo;
}
