<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Models;

use App\Containers\AppSection\Activity\Models\UserActivity;
use App\Containers\AppSection\Authentication\Traits\AuthenticationTrait;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Traits\AuthorizationTrait;
use App\Containers\AppSection\Client\Models\Client as ClientModel;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignRecipient;
use App\Containers\AppSection\FixedIndexAnnuities\Models\RecipientInterface;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\User\Notifications\ResetPasswordNotification;
use App\Containers\AppSection\User\Notifications\VerifyEmailNotification;
use App\Containers\AppSection\User\Traits\HasUserAvatar;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Traits\EagerLoadPivotBuilder;
use datetime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Laravel\Passport\Client;
use Laravel\Passport\Token;
use Zavrik\LaravelTelegram\Models\TelegramUserInterface;
use Zavrik\LaravelTelegram\Traits\WithTelegramUserTrait;

/**
 * Class User.
 *
 * @OA\Schema (
 *     title="User",
 *     description="User data model",
 *     required={"id", "first_name", "last_name", "email", "username"},
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="05e6laz40wojymb3"
 *     ),
 *     @OA\Property (
 *          property="email",
 *          type="string",
 *          example="admin@admin.com"
 *     ),
 *     @OA\Property (
 *          property="first_name",
 *          type="string",
 *          example="Test"
 *     ),
 *     @OA\Property (
 *          property="last_name",
 *          type="string",
 *          example="Test"
 *     ),
 *     @OA\Property (
 *          property="username",
 *          type="string",
 *          example="test"
 *     ),
 *     @OA\Property (
 *          property="position",
 *          type="string",
 *          example="Test Position"
 *     ),
 *     @OA\Property (
 *          property="phone",
 *          type="string",
 *          example="+123456789"
 *     ),
 *     @OA\Property (
 *          property="npn",
 *          type="string",
 *          example="12345"
 *     ),
 * )
 *
 * @property      int                                                   $id
 * @property      int                                                   $company_id             User company
 * @property      string                                                $first_name
 * @property      string                                                $last_name
 * @property      string                                                $email
 * @property      string                                                $username
 * @property      string                                                $password
 * @property      Carbon|null                                           $email_verified_at      Email confirmed date
 * @property      bool                                                  $is_client              Indicates it's admin or it's client
 * @property      string|null                                           $data_source            Enum of sources ("UserUploaded", "Bloomberg", "Morningstar") to fetch ticket financial data
 * @property      string|null                                           $remember_token         OAuth2 token
 * @property      string|null                                           $position
 * @property      string|null                                           $phone
 * @property      Carbon|null                                           $phone_verified_at
 * @property      string|null                                           $npn
 * @property      Carbon|null                                           $last_login_at
 * @property      string|null                                           $last_login_ip
 * @property      Carbon|null                                           $created_at
 * @property      Carbon|null                                           $updated_at
 * @property      Carbon|null                                           $deleted_at
 * @property      Collection|null                                       $members
 * @property      ClientModel|null                                      $client
 * @property      SalesforceUser|null                                   $salesforce
 * @property      Company                                               $company
 * @property      DocusignRecipient|null                                $recipient
 * @property-read Collection|Client[]                                   $clients
 * @property-read int|null                                              $clients_count
 * @property-read int|null                                              $factors_count
 * @property-read string                                                $avatar_url
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null                                              $notifications_count
 * @property-read int|null                                              $payment_accounts_count
 * @property-read Collection|Permission[]                               $permissions
 * @property-read int|null                                              $permissions_count
 * @property-read int|null                                              $processes_count
 * @property-read Collection|Role[]                                     $roles
 * @property-read int|null                                              $roles_count
 * @property-read int|null                                              $screens_count
 * @property-read Collection|Token[]                                    $tokens
 * @property-read Collection|null                                       $assistants
 * @property-read Collection|null                                       $advisors
 * @property-read UsersTransfer|null                                    $usersTransferTo
 * @property-read Collection                                            $usersTransferFrom
 * @property-read int|null                                              $tokens_count
 *
 * @method static Builder|User countByDays($startDate = null, $stopDate = null, $dateColumn = 'created_at')
 * @method static Builder|User countForGroup($groupColumn)
 * @method static Builder|User defaultSort($column, $direction = 'asc')
 * @method static Builder|User filtersApply($filters = [])
 * @method static Builder|User filtersApplySelection($selection)
 * @method static EagerLoadPivotBuilder|User newModelQuery()
 * @method static EagerLoadPivotBuilder|User newQuery()
 * @method static Builder|UserModel permission($permissions)
 * @method static EagerLoadPivotBuilder|User query()
 * @method static Builder|UserModel role($roles, $guard = null)
 * @method static Builder|User sumByDays($value, $startDate = null, $stopDate = null, $dateColumn = 'created_at')
 * @method static Builder|User valuesByDays($value, $startDate = null, $stopDate = null, $dateColumn = 'created_at')
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCompanyId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDataSource($value)
 * @method static Builder|User whereDefaultProcessId($value)
 * @method static Builder|User whereDefaultScreenId($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsClient($value)
 * @method static Builder|User whereLastLoginAt($value)
 * @method static Builder|User whereLastLoginIp($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 */
class User extends UserModel implements MustVerifyEmail, HasInteractsWithMedia, RecipientInterface, TelegramUserInterface
{
    use AuthenticationTrait;
    use AuthorizationTrait;
    use HasUserAvatar;
    use WithTelegramUserTrait;

    protected static bool $useLogger = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'data_source',
        'is_client',
        'email_verified_at',
        'last_login_at',
        'last_login_ip',
        'position',
        'phone',
        'phone_verified_at',
        'npn',
        'company_id',
    ];

    /**
     * @var array<string, string|class-string<datetime>>
     */
    protected $casts = [
        'is_client'          => 'boolean',
        'last_login_at'      => 'datetime',
        'email_verified_at'  => 'datetime',
        'phone_verified_at'  => 'datetime',
        'deleted_at'         => 'datetime',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function getAuthorId(): int
    {
        return $this->getKey();
    }

    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    public function salesforce(): HasOne
    {
        return $this->hasOne(SalesforceUser::class);
    }

    public function client(): HasOne
    {
        return $this->hasOne(ClientModel::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function assistants(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'advisor_assistant', 'advisor_id', 'assistant_id');
    }

    public function advisors(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'advisor_assistant', 'assistant_id', 'advisor_id');
    }

    public function usersTransferTo(): HasOne
    {
        return $this->hasOne(UsersTransfer::class, 'from_id');
    }

    public function usersTransferFrom(): HasMany
    {
        return $this->hasMany(UsersTransfer::class, 'to_id');
    }

    public function transferTo(): ?self
    {
        return $this->usersTransferTo?->toUser;
    }

    public function transferFrom(): \Illuminate\Support\Collection
    {
        return $this->usersTransferFrom->map(function (UsersTransfer $transfer): self {
            $transfer = $transfer->load('fromUser');

            return $transfer->fromUser;
        });
    }

    public function recipient(): MorphOne
    {
        return $this->morphOne(DocusignRecipient::class, 'recipient');
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    public function isDeleted(): bool
    {
        return $this->deleted_at !== null;
    }
}
