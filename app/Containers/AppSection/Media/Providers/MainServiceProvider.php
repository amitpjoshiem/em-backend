<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Providers;

use App\Containers\AppSection\Media\Services\FileAdder;
use App\Containers\AppSection\Media\UI\CLI\Commands\TemporaryClearCommand;
use App\Ship\Parents\Providers\MainProvider;
use FFMpeg\FFMpeg;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Spatie\MediaLibrary\MediaCollections\FileAdder as BaseFileAdder;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        MediaLibraryServiceProvider::class,
        AuthProvider::class,
        EventServiceProvider::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        if (config('media-container.enabled-schedule-temporary-clean')) {
            $this->app->booted(function (Application $app): void {
                $app->make(Schedule::class)->command(TemporaryClearCommand::class)->everySixHours();
            });
        }
    }

    public function register(): void
    {
        parent::register();

        $this->app->singleton('ffmpeg-driver', fn (): FFMpeg => FFMpeg::create([
            'ffmpeg.binaries'  => config('media-library.ffmpeg_path'),
            'ffprobe.binaries' => config('media-library.ffprobe_path'),
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,
        ]));

        $this->app->bind(BaseFileAdder::class, FileAdder::class);
    }
}
