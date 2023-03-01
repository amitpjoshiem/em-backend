<?php

namespace App\Ship\Providers;

use App\Ship\Manifest\MergePluginPackageManifest;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Support\ServiceProvider;

class MergePluginServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /**
         * Override the package manifest with the apiato custom one.
         * This ensures that the laravel extras in the composer json's are read for all containers.
         */
        $this->overridePackageManifest();
    }

    private function overridePackageManifest(): void
    {
        $this->app->instance(PackageManifest::class, new MergePluginPackageManifest(
            $this->app->make(PackageManifest::class)
        ));
    }
}
