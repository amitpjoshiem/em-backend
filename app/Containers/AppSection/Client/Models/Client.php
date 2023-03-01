<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Models;

use App\Containers\AppSection\Client\Data\Enums\ClientDocumentsEnum;
use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Traits\InteractsWithMedia;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * @property int                        $id
 * @property string                     $completed_financial_fact_finder
 * @property string                     $investment_and_retirement_accounts
 * @property string                     $life_insurance_annuity_and_long_terms_care_policies
 * @property string                     $social_security_information
 * @property string                     $medicare_details
 * @property string                     $property_casualty
 * @property bool                       $terms_and_conditions
 * @property string                     $consultation
 * @property Member                     $member
 * @property User                       $user
 * @property bool                       $is_submit
 * @property bool                       $readonly
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $first_fill_info
 * @property \Illuminate\Support\Carbon $converted_from_lead
 * @property \Illuminate\Support\Carbon $closed_win_lost
 */
class Client extends Model implements HasInteractsWithMedia, BelongToMemberInterface
{
    use InteractsWithMedia;

    /**
     * @var string
     */
    public const NOT_COMPLETED_STEP = 'not_completed';

    /**
     * @var string
     */
    public const NO_DOCUMENTS_STEP = 'no_documents';

    /**
     * @var string
     */
    public const COMPLETED_STEP = 'completed';

    /**
     * @var string
     */
    public const WANT_CONSULTATION_AND_BOOK = 'want_consultation_and_book';

    /**
     * @var string
     */
    public const WANT_CONSULTATION = 'want_consultation';

    /**
     * @var string
     */
    public const DONT_WANT_CONSULTATION = 'dont_want_consultation';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'completed_financial_fact_finder',
        'investment_and_retirement_accounts',
        'life_insurance_annuity_and_long_terms_care_policies',
        'social_security_information',
        'medicare_details',
        'property_casualty',
        'consultation',
        'terms_and_conditions',
        'member_id',
        'user_id',
        'is_submit',
        'first_fill_info',
        'converted_from_lead',
        'closed_win_lost',
        'readonly',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'readonly' => false,
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
        'created_at'                                          => 'datetime',
        'updated_at'                                          => 'datetime',
        'first_fill_info'                                     => 'datetime',
        'converted_from_lead'                                 => 'datetime',
        'closed_win_lost'                                     => 'datetime',
        'terms_and_conditions'                                => 'bool',
        'is_submit'                                           => 'bool',
        'readonly'                                            => 'bool',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Client';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class)->withTrashed();
    }

    public function getAuthorId(): ?int
    {
        return $this->user->getKey();
    }

    public function getCollection(): string
    {
        return (string)null;
    }

    public function getCollectionDocs(string $collection): MediaCollection
    {
        return $this->getMedia($collection);
    }

    public function isCompleted(): bool
    {
        foreach (ClientDocumentsEnum::requiredSteps() as $step) {
            if ($this->{$step} === self::NOT_COMPLETED_STEP) {
                return false;
            }
        }

        return true;
    }

    public function calculateOnBoarding(): float
    {
        $result = 0;
        foreach (ClientDocumentsEnum::values() as $step) {
            $result += (int)($this->{$step} !== self::NOT_COMPLETED_STEP);
        }

        $result += (int)$this->is_submit;

        $count = \count(ClientDocumentsEnum::values()) + 1;

        return $result / $count * 100;
    }
}
