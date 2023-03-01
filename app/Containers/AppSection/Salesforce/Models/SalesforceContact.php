<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\OwnerNotExistException;
use App\Containers\AppSection\Salesforce\Services\Objects\Contact;
use App\Ship\Parents\Models\Model;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int               $id
 * @property int               $member_id
 * @property string            $salesforce_id
 * @property MemberContact     $contact
 * @property SalesforceAccount $account
 */
class SalesforceContact extends Model implements BelongToMemberInterface, SalesforceObjectInterface
{
    use SoftDeletes;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'salesforce_id',
        'salesforce_account_id',
        'contact_id',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Salesforce';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(SalesforceAccount::class);
    }

    public function api(): Contact
    {
        return new Contact($this);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(MemberContact::class);
    }

    public static function prepareSalesforceData(int $id, bool $isUpdate): array
    {
        /** @var self $contact */
        $contact = self::with(['member.salesforce', 'member.user.salesforce'])->find($id);

        try {
            $ownerID = $contact->member->user->salesforce->salesforce_id;
        } catch (Exception) {
            throw new OwnerNotExistException();
        }

        return [
            'FirstName'     => $contact->contact->first_name,
            'LastName'      => $contact->contact->last_name,
            'Title'         => '',
            'Phone'         => $contact->contact->phone,
            'AccountId'     => $contact->member->salesforce->salesforce_id,
            'Email'         => $contact->contact->email,
            'Birthdate'     => $contact->contact->birthday?->format('Y-m-d'),
            'OwnerId'       => $ownerID,
        ];
    }

    public function getSalesforceId(): ?string
    {
        return $this->salesforce_id;
    }
}
