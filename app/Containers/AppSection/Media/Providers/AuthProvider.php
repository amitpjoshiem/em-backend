<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Providers;

use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\Policies\MediaPolicy;
use App\Ship\Parents\Providers\AuthProvider as ParentAuthProvider;

class AuthProvider extends ParentAuthProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Media::class => MediaPolicy::class,
    ];
}
