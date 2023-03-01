<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\OwnerNotExistException;
use App\Containers\AppSection\Salesforce\Services\Objects\Account;
use App\Ship\Parents\Models\Model;
use  Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int                   $id
 * @property int                   $member_id
 * @property string                $salesforce_id
 * @property bool|null             $do_not_mail
 * @property string | null         $category
 * @property Carbon | null         $client_start_date
 * @property Carbon | null         $client_ar_date
 * @property bool|null             $p_c_client
 * @property bool|null             $tax_conversion_client
 * @property bool|null             $platinum_club_client
 * @property bool|null             $medicare_client
 * @property float|null            $household_value
 * @property string|null           $total_investment_size
 * @property string|null           $political_stance
 * @property float|null            $client_average_age
 * @property bool|null             $primary_contact
 * @property bool|null             $military_veteran
 * @property bool|null             $homework_completed
 * @property SalesforceContact     $contact
 * @property SalesforceOpportunity $opportunity
 * @property Collection | array    $attachments
 * @property Collection            $annualReviews
 */
class SalesforceAccount extends Model implements BelongToMemberInterface, SalesforceObjectInterface
{
    use SoftDeletes;

    /**
     * @var string
     */
    public const COUNTRY = 'USA';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'salesforce_id',
        'do_not_mail',
        'category',
        'client_start_date',
        'client_ar_date',
        'p_c_client',
        'tax_conversion_client',
        'platinum_club_client',
        'medicare_client',
        'household_value',
        'total_investment_size',
        'political_stance',
        'client_average_age',
        'primary_contact',
        'military_veteran',
        'homework_completed',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array<string, class-string<\datetime>>|array<string, string>
     */
    protected $casts = [
        'p_c_client'            => 'boolean',
        'tax_conversion_client' => 'boolean',
        'platinum_club_client'  => 'boolean',
        'do_not_mail'           => 'boolean',
        'medicare_client'       => 'boolean',
        'primary_contact'       => 'boolean',
        'military_veteran'      => 'boolean',
        'homework_completed'    => 'boolean',
        'client_start_date'     => 'datetime',
        'client_ar_date'        => 'datetime',
        'household_value'       => 'float',
        'client_average_age'    => 'float',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Salesforce';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function api(): Account
    {
        return new Account($this);
    }

    public function contact(): HasMany
    {
        return $this->hasMany(SalesforceContact::class);
    }

    public function opportunity(): HasOne
    {
        return $this->hasOne(SalesforceOpportunity::class);
    }

    /**
     * @throws OwnerNotExistException
     */
    public static function prepareSalesforceData(int $id, bool $isUpdate): array
    {
        /** @var self $account */
        $account = self::with(['member', 'member.user.salesforce'])->find($id);

        try {
            $ownerID = $account->member->user->salesforce->salesforce_id;
        } catch (Exception) {
            throw new OwnerNotExistException();
        }

        return [
            'Name'                      => $account->member->name,
            'Client_Email_Primary__c'   => $account->member->email,
            'Phone'                     => $account->member->phone,
            'Type'                      => $account->member->type,
            'BillingStreet'             => $account->member->address,
            'BillingState'              => $account->member->state,
            'BillingCity'               => $account->member->city,
            'BillingCountry'            => self::COUNTRY,
            'BillingPostalCode'         => $account->member->zip,
            'OwnerId'                   => $ownerID,
        ];
    }

    public function getSalesforceId(): ?string
    {
        return $this->salesforce_id;
    }

    public function getAttachmentsAttribute(): Collection|array
    {
        /** @psalm-suppress UndefinedThisPropertyFetch */
        return SalesforceAttachment::where([
            'object_class'  => self::class,
            'object_id'     => $this->id,
        ])->get();
    }

    public function annualReviews(): HasMany
    {
        return $this->hasMany(SalesforceAnnualReview::class, 'account_id');
    }
}
