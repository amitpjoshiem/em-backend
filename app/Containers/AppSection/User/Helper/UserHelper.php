<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Helper;

use App\Containers\AppSection\User\Exceptions\UserHelperAlreadyCreatedException;
use App\Containers\AppSection\User\Exceptions\UserHelperNotCreatedException;
use App\Containers\AppSection\User\Models\Company;
use App\Containers\AppSection\User\Models\User;

class UserHelper
{
    public function user(): User
    {
        return $this->user;
    }

    public function mainUser(): User
    {
        return $this->mainUser;
    }

    public function company(): Company
    {
        return $this->company;
    }

    protected static ?self $instance = null;

    /** call this method to get instance */
    public static function instance(): self
    {
        if (static::$instance === null) {
            throw new UserHelperNotCreatedException();
        }

        return static::$instance;
    }

    public static function setInstance(User $mainUser, User $user, Company $company): void
    {
        if (static::$instance !== null) {
            throw new UserHelperAlreadyCreatedException();
        }

        static::$instance = new self($mainUser, $user, $company);
    }

    /** protected to prevent cloning */
    protected function __clone()
    {
    }

    /** protected to prevent instantiation from outside of the class */
    protected function __construct(private User $mainUser, private User $user, private Company $company)
    {
    }
}
