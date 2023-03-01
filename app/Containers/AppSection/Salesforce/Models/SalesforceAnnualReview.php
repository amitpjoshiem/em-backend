<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\OwnerNotExistException;
use App\Containers\AppSection\Salesforce\Services\Objects\AnnualReview;
use App\Ship\Parents\Models\Model;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class SalesforceAnnualReview.
 *
 * @property int                             $id
 * @property int                             $member_id
 * @property string                          $salesforce_id
 * @property SalesforceAccount               $account
 * @property string|null                     $name
 * @property \Illuminate\Support\Carbon|null $review_date
 * @property float|null                      $amount
 * @property string|null                     $type
 * @property string|null                     $new_money
 * @property string|null                     $notes
 */
class SalesforceAnnualReview extends Model implements BelongToMemberInterface, SalesforceObjectInterface
{
    /**
     * @var string[]
     */
    public const TYPE = [
        'Alternative',
        'Annuity',
        'Insurance',
        'Managed Money',
    ];

    /**
     * @var string[]
     */
    public const NEW_MONEY = [
        'Yes',
        'No',
    ];

    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'account_id',
        'salesforce_id',
        'name',
        'review_date',
        'amount',
        'type',
        'new_money',
        'notes',
    ];

    /**
     * @var array<string>
     */
    protected $casts = [
        'review_date'       => 'datetime',
        'amount'            => 'float',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceAnnualReview';

    public function account(): BelongsTo
    {
        return $this->belongsTo(SalesforceAccount::class, 'account_id');
    }

    public function api(): AnnualReview
    {
        return new AnnualReview($this);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public static function prepareSalesforceData(int $id, bool $isUpdate): array
    {
        /** @var self $annualReview */
        $annualReview = self::with(['account', 'member.user.salesforce'])->find($id);

        try {
            $ownerID = $annualReview->member->user->salesforce->salesforce_id;
        } catch (Exception) {
            throw new OwnerNotExistException();
        }

        return [
            'Client_Account__c'     => $annualReview->account->salesforce_id,
            'OwnerId'               => $ownerID,
            'Name'                  => $annualReview->name,
            'Annual_Review_Date__c' => $annualReview->review_date?->format('Y-m-d'),
            'Amount__c'             => $annualReview->amount,
            'Type__c'               => $annualReview->type,
            'Bringing_New_Money__c' => $annualReview->new_money,
            'Notes__c'              => $annualReview->notes,
        ];
    }

    public function getSalesforceId(): ?string
    {
        return $this->salesforce_id;
    }
}
