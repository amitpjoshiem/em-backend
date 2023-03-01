<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Models;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Client\Models\ClientConfirmation;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignRecipient;
use App\Containers\AppSection\FixedIndexAnnuities\Models\RecipientInterface;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Traits\HasUserAvatar;
use App\Containers\AppSection\Yodlee\Models\YodleeMember;
use App\Ship\Parents\Models\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Class Member.
 *
 * @OA\Schema (
 *     title="Member",
 *     description="Member Basic Info",
 *     required={"id"},
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
 *     ),
 *     @OA\Property (
 *          property="type",
 *          description="One of the type (client|prospect)",
 *          type="string",
 *          example="client"
 *     ),
 *     @OA\Property (
 *          property="name",
 *          type="string",
 *          example="Name"
 *     ),
 *     @OA\Property (
 *          property="email",
 *          type="string",
 *          example="test@test.com"
 *     ),
 *     @OA\Property (
 *          property="birthday",
 *          type="string",
 *          example="1970-01-01"
 *     ),
 *     @OA\Property (
 *          property="phone",
 *          type="string",
 *          example="+1 (123) 456-7890"
 *     ),
 *     @OA\Property (
 *          property="married",
 *          type="boolean",
 *          example=true
 *     ),
 *     @OA\Property (
 *          property="retired",
 *          type="boolean",
 *          example=true
 *     ),
 *     @OA\Property (
 *          property="retirement_date",
 *          type="string",
 *          example="1970-01-01"
 *     ),
 *     @OA\Property (
 *          property="address",
 *          type="string",
 *          example="123 Test Address str."
 *     ),
 *     @OA\Property (
 *          property="city",
 *          type="string",
 *          example="Test City"
 *     ),
 *     @OA\Property (
 *          property="zip",
 *          type="string",
 *          example="12345"
 *     ),
 *     @OA\Property (
 *          property="notes",
 *          type="string",
 *          example="Test Note"
 *     ),
 *     @OA\Property(
 *          property="spouse",
 *          ref="#/components/schemas/MemberContact"
 *     ),
 *     @OA\Property(
 *          property="house",
 *          ref="#/components/schemas/MemberHouse"
 *     ),
 *     @OA\Property(
 *          property="other",
 *          ref="#/components/schemas/MemberOther"
 *     ),
 *     @OA\Property(
 *          property="employment_history",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/MemberEmploymentHistory")
 *     )
 * )
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property string                          $type
 * @property bool|null                       $retired
 * @property \Illuminate\Support\Carbon|null $retirement_date
 * @property bool                            $married
 * @property string|null                     $channels
 * @property bool                            $is_watch
 * @property string                          $name
 * @property string                          $email
 * @property string                          $phone
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property string                          $address
 * @property string                          $city
 * @property string                          $state
 * @property string                          $zip
 * @property string                          $step
 * @property string | null                   $notes
 * @property string                          $biggest_financial_concern
 * @property string                          $amount_for_retirement
 * @property float                           $total_net_worth
 * @property float                           $goal
 * @property \Illuminate\Support\Carbon      $created_at
 * @property \Illuminate\Support\Carbon      $updated_at
 * @property \Illuminate\Support\Carbon      $deleted_at
 * @property MemberContact|null              $spouse
 * @property Collection|null                 $contacts
 * @property Collection|null                 $employmentHistory
 * @property MemberHouse|null                $house
 * @property MemberOther|null                $other
 * @property YodleeMember|null               $yodlee
 * @property SalesforceAccount|null          $salesforce
 * @property Collection|null                 $assetsConsolidations
 * @property Client|null                     $client
 * @property User                            $user
 * @property DocusignRecipient|null          $recipient
 */
class Member extends Model implements PersonInterface, HasInteractsWithMedia, RecipientInterface
{
    use HasUserAvatar;
    use SoftDeletes;

    /**
     * @var string
     */
    public const PROSPECT = 'prospect';

    /**
     * @var string
     */
    public const CLIENT = 'client';

    /**
     * @var string
     */
    public const PRE_LEAD = 'pre_lead';

    /**
     * @var string
     */
    public const LEAD = 'lead';

    /**
     * @var string
     */
    public const TYPE = 'Member';

    /**
     * @var string
     */
    public const ACTIVE_STATUS = 'active';

    /**
     * @var string
     */
    public const INACTIVE_STATUS = 'inactive';

    /**
     * @var string[]
     */
    public const AMOUNT_FOR_RETIREMENT_TYPE = [
        '150000',
        '250000',
        '500000',
        '1000000',
    ];

    /**
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'retired',
        'married',
        'name',
        'email',
        'phone',
        'birthday',
        'retirement_date',
        'address',
        'city',
        'state',
        'zip',
        'spouse_id',
        'user_id',
        'step',
        'notes',
        'total_net_worth',
        'goal',
        'amount_for_retirement',
        'biggest_financial_concern',
        'channels',
        'is_watch',
        'created_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
        'birthday'        => 'date:Y-m-d',
        'retirement_date' => 'date:Y-m-d',
        'retired'         => 'boolean',
        'married'         => 'boolean',
        'is_watch'        => 'boolean',
        'total_net_worth' => 'float',
        'goal'            => 'float',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Member';

    /** @psalm-suppress InvalidReturnType */
    public function contacts(): HasMany
    {
        /** @psalm-suppress InvalidReturnStatement */
        return $this->hasMany(MemberContact::class)->where(['is_spouse' => false]);
    }

    /** @psalm-suppress InvalidReturnType */
    public function spouse(): HasOne
    {
        /** @psalm-suppress InvalidReturnStatement */
        return $this->hasOne(MemberContact::class)->where(['is_spouse' => true]);
    }

    public function house(): hasOne
    {
        return $this->hasOne(MemberHouse::class);
    }

    public function employmentHistory(): MorphMany
    {
        return $this->morphMany(MemberEmploymentHistory::class, 'memberable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function other(): HasOne
    {
        return $this->hasOne(MemberOther::class);
    }

    /** @FIXME: think about $retired and $retirement_date as one field with accessor */
    public function getRetiredAttribute(): bool
    {
        return $this->retirement_date !== null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthday(): ?Carbon
    {
        return $this->birthday;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAge(): ?int
    {
        return $this->birthday?->age;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function yodlee(): HasOne
    {
        return $this->hasOne(YodleeMember::class);
    }

    public function salesforce(): HasOne
    {
        return $this->hasOne(SalesforceAccount::class)->withDefault([
            'member_id' => $this->getKey(),
        ]);
    }

    public function getAuthorId(): int
    {
        return $this->getKey();
    }

    public function assetsConsolidations(): HasMany
    {
        return $this->hasMany(AssetsConsolidations::class);
    }

    public function getStressTests(): MediaCollection
    {
        return $this->getMedia(MediaCollectionEnum::STRESS_TEST);
    }

    public function getAssetsConsolidationDocs(): MediaCollection
    {
        return $this->getMedia(MediaCollectionEnum::ASSETS_CONSOLIDATIONS_DOCS);
    }

    public function confirmations(): HasMany
    {
        return $this->hasMany(ClientConfirmation::class);
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function recipient(): MorphOne
    {
        return $this->morphOne(DocusignRecipient::class, 'recipient');
    }
}
