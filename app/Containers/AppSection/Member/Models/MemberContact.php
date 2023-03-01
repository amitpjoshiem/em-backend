<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Models;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Ship\Parents\Models\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class MemberContact.
 *
 * @OA\Schema (
 *     title="MemberContact",
 *     description="Member Contact Info",
 *     required={"id"},
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="egrlyazq98mno3k0"
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
 *          property="phone",
 *          type="string",
 *          example="+1 (123) 456-7890"
 *     ),
 *     @OA\Property(
 *          property="is_spouse",
 *          type="boolean",
 *          example=true
 *     ),
 * )
 *
 * @property int                             $id
 * @property bool | null                     $retired
 * @property \Illuminate\Support\Carbon|null $retirement_date
 * @property string                          $first_name
 * @property string                          $last_name
 * @property string                          $email
 * @property string                          $phone
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property \Illuminate\Support\Carbon      $created_at
 * @property \Illuminate\Support\Carbon      $updated_at
 * @property Collection|null                 $employmentHistory
 * @property bool                            $is_spouse
 * @property Member                          $member
 * @property SalesforceContact               $salesforce
 */
class MemberContact extends Model implements PersonInterface, BelongToMemberInterface
{
    /**
     * @var string
     */
    public const TYPE = 'MemberContact';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'birthday',
        'email',
        'phone',
        'retired',
        'retirement_date',
        'member_id',
        'is_spouse',
        'first_name',
        'last_name',
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
        'is_spouse'       => 'boolean',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'MemberContact';

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function employmentHistory(): MorphMany
    {
        return $this->morphMany(MemberEmploymentHistory::class, 'memberable');
    }

    public function getName(): string
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
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
        return $this->member->user_id;
    }

    public function salesforce(): HasOne
    {
        return $this->hasOne(SalesforceContact::class, 'contact_id')->withDefault([
            'contact_id' => $this->getKey(),
            'member_id'  => $this->member->getKey(),
        ]);
    }
}
