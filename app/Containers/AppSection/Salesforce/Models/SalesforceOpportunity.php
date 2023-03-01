<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\OwnerNotExistException;
use App\Containers\AppSection\Salesforce\Services\Objects\Opportunity;
use App\Ship\Parents\Models\Model;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SalesforceOpportunity.
 *
 * @property int                             $id
 * @property int                             $member_id
 * @property string                          $salesforce_id
 * @property string | null                   $investment_size
 * @property string                          $stage
 * @property SalesforceAccount               $account
 * @property Collection                      $childOpportunities
 * @property \Illuminate\Support\Carbon      $close_date
 * @property \Illuminate\Support\Carbon|null $date_of_1st
 * @property \Illuminate\Support\Carbon|null $date_of_2nd
 * @property \Illuminate\Support\Carbon|null $date_of_3rd
 * @property string|null                     $result_1st_appt
 * @property string|null                     $result_2nd_appt
 * @property string|null                     $result_3rd_appt
 * @property string|null                     $status_1st_appt
 * @property string|null                     $status_2nd_appt
 * @property string|null                     $status_3rd_appt
 * @property bool                            $convert_close_win
 */
class SalesforceOpportunity extends Model implements BelongToMemberInterface, SalesforceObjectInterface
{
    /**
     * @var null
     */
    public const DEFAULT_INVESTMENT_SIZE = null;

    /**
     * @var string
     */
    public const DEFAULT_STAGE = 'Prospect';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'salesforce_id',
        'salesforce_account_id',
        'investment_size',
        'close_date',
        'stage',
        'date_of_1st',
        'date_of_2nd',
        'date_of_3rd',
        'result_1st_appt',
        'result_2nd_appt',
        'result_3rd_appt',
        'status_1st_appt',
        'status_2nd_appt',
        'status_3rd_appt',
        'convert_close_win',
    ];

    /**
     * @var array<string>
     */
    protected $casts = [
        'close_date'        => 'datetime',
        'date_of_1st'       => 'datetime',
        'date_of_2nd'       => 'datetime',
        'date_of_3rd'       => 'datetime',
        'convert_close_win' => 'bool',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceOpportunity';

    public function account(): BelongsTo
    {
        return $this->belongsTo(SalesforceAccount::class, 'salesforce_account_id');
    }

    public function childOpportunities(): HasMany
    {
        return $this->hasMany(SalesforceChildOpportunity::class);
    }

    public function api(): Opportunity
    {
        return new Opportunity($this);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public static function prepareSalesforceData(int $id, bool $isUpdate): array
    {
        /** @var self $opportunity */
        $opportunity = self::with(['account', 'member.user.salesforce'])->find($id);

        try {
            $ownerID = $opportunity->member->user->salesforce->salesforce_id;
        } catch (Exception) {
            throw new OwnerNotExistException();
        }

        return [
            'AccountId'                         => $opportunity->account->salesforce_id,
            'Name'                              => $opportunity->member->name . ' Opportunity',
            'CloseDate'                         => $opportunity->close_date->format('Y-m-d'),
            'StageName'                         => OpportunityStageEnum::getTitle($opportunity->stage),
            'Total_Investment_Size__c'          => $opportunity->investment_size,
            'OwnerId'                           => $ownerID,
            'Master_Opportunity__c'             => true,
            'Date_of_1st__c'                    => $opportunity->date_of_1st?->format('Y-m-d'),
            'Date_of_2nd__c'                    => $opportunity->date_of_2nd?->format('Y-m-d'),
            'Date_of_3rd__c'                    => $opportunity->date_of_3rd?->format('Y-m-d'),
            'X1st_Appt_Results__c'              => $opportunity->result_1st_appt,
            'X2nd_Appt_Results__c'              => $opportunity->result_2nd_appt,
            'X3rd_Appt_Results__c'              => $opportunity->result_3rd_appt,
            'X1st_Appointment_Status__c'        => $opportunity->status_1st_appt,
            'X2nd_Appointment_Status__c'        => $opportunity->status_2nd_appt,
            'X3rd_Appointment_Status__c'        => $opportunity->status_3rd_appt,
        ];
    }

    public function getSalesforceId(): ?string
    {
        return $this->salesforce_id;
    }
}
