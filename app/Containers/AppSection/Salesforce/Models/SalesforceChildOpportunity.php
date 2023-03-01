<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\OwnerNotExistException;
use App\Containers\AppSection\Salesforce\Services\Objects\ChildOpportunity;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SalesforceOpportunity.
 *
 * @property int                        $id
 * @property int                        $member_id
 * @property string                     $salesforce_id
 * @property string                     $stage
 * @property string                     $name
 * @property string                     $type
 * @property float                      $amount
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $close_date
 * @property \Illuminate\Support\Carbon $updated_at
 * @property SalesforceOpportunity      $opportunity
 * @property User                       $user
 * @property Member                     $member
 */
class SalesforceChildOpportunity extends Model implements BelongToMemberInterface, SalesforceObjectInterface
{
    use SoftDeletes;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'salesforce_id',
        'salesforce_opportunity_id',
        'stage',
        'amount',
        'created_at',
        'name',
        'type',
        'close_date',
        'user_id',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
        'close_date'      => 'datetime',
        'amount'          => 'float',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceChildOpportunity';

    public function opportunity(): BelongsTo
    {
        return $this->belongsTo(SalesforceOpportunity::class, 'salesforce_opportunity_id');
    }

    public function api(): ChildOpportunity
    {
        return new ChildOpportunity($this);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public static function prepareSalesforceData(int $id, bool $isUpdate = false): array
    {
        /** @var self $childOpp */
        $childOpp = self::with(['opportunity.account', 'user.salesforce'])->find($id);

        $data = [
            'Opportunity_Amount__c'         => $childOpp->amount,
            'Close_Date__c'                 => $childOpp->close_date->format('Y-m-d'),
            'Name'                          => $childOpp->name,
            'Child_Opportunity_Stage__c'    => $childOpp->stage,
            'Type__c'                       => $childOpp->type,
            'Primary_Campaign_Source__c'    => config('appSection-salesforce.campaign_id'),
        ];

        try {
            $ownerID = $childOpp->user->salesforce->salesforce_id;
        } catch (Exception) {
            throw new OwnerNotExistException();
        }

        if (!$isUpdate) {
            $data['Client_Account__c']          = $childOpp->opportunity->account->salesforce_id;
            $data['Child_Opportunity_Owner__c'] = $ownerID;
            $data['Opportunity__c']             = $childOpp->opportunity->salesforce_id;
        }

        return $data;
    }

    public function getSalesforceId(): ?string
    {
        return $this->salesforce_id;
    }
}
