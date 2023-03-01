<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Member                            $member
 * @property int                               $member_id
 * @property string                            $contract_number
 * @property string | null                     $carrier
 * @property float | null                      $current_value
 * @property float | null                      $surrender_value
 * @property float | null                      $origination_value
 * @property float | null                      $current_interest_credited
 * @property float | null                      $withdrawals
 * @property float | null                      $total_premiums
 * @property float | null                      $bonus_received
 * @property float | null                      $since_interest_credited
 * @property float | null                      $total_withdrawals
 * @property float | null                      $total_fees
 * @property float | null                      $rmd_or_sys_wd
 * @property bool                              $is_custom
 * @property int | null                        $contract_years
 * @property \Illuminate\Support\Carbon | null $origination_date
 * @property string | null                     $formatted_origination_date
 * @property \Illuminate\Support\Carbon        $created_at
 * @property \Illuminate\Support\Carbon        $updated_at
 */
class ClientReport extends Model implements BelongToMemberInterface
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'contract_number',
        'carrier',
        'current_value',
        'surrender_value',
        'origination_value',
        'origination_date',
        'current_interest_credited',
        'withdrawals',
        'total_premiums',
        'bonus_received',
        'since_interest_credited',
        'total_withdrawals',
        'total_fees',
        'rmd_or_sys_wd',
        'is_custom',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'contract_years',
        'formatted_origination_date',
    ];

    /**
     * @var array<string>
     */
    protected $hidden = [

    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'                => 'datetime',
        'updated_at'                => 'datetime',
        'origination_date'          => 'date',
        'current_value'             => 'float',
        'surrender_value'           => 'float',
        'origination_value'         => 'float',
        'current_interest_credited' => 'float',
        'withdrawals'               => 'float',
        'total_premiums'            => 'float',
        'bonus_received'            => 'float',
        'since_interest_credited'   => 'float',
        'total_withdrawals'         => 'float',
        'total_fees'                => 'float',
        'rmd_or_sys_wd'             => 'float',
        'is_custom'                 => 'bool',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'ClientReport';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function getFormattedOriginationDateAttribute(): ?string
    {
        return $this->origination_date?->format('m/d/Y');
    }

    public function getContractYearsAttribute(): ?int
    {
        return $this->origination_date?->diff(now())->y;
    }
}
