<?php

namespace App\Ship\Core\Generator;

use App\Ship\Core\Generator\Commands\ActionGenerator;
use App\Ship\Core\Generator\Commands\ConfigurationGenerator;
use App\Ship\Core\Generator\Commands\ContainerApiGenerator;
use App\Ship\Core\Generator\Commands\ContainerGenerator;
use App\Ship\Core\Generator\Commands\ContainerWebGenerator;
use App\Ship\Core\Generator\Commands\ControllerGenerator;
use App\Ship\Core\Generator\Commands\EventGenerator;
use App\Ship\Core\Generator\Commands\EventHandlerGenerator;
use App\Ship\Core\Generator\Commands\ExceptionGenerator;
use App\Ship\Core\Generator\Commands\FactoryGenerator;
use App\Ship\Core\Generator\Commands\JobGenerator;
use App\Ship\Core\Generator\Commands\MailGenerator;
use App\Ship\Core\Generator\Commands\MigrationGenerator;
use App\Ship\Core\Generator\Commands\ModelGenerator;
use App\Ship\Core\Generator\Commands\NotificationGenerator;
use App\Ship\Core\Generator\Commands\ReadmeGenerator;
use App\Ship\Core\Generator\Commands\RepositoryGenerator;
use App\Ship\Core\Generator\Commands\RequestGenerator;
use App\Ship\Core\Generator\Commands\RouteGenerator;
use App\Ship\Core\Generator\Commands\SeederGenerator;
use App\Ship\Core\Generator\Commands\ServiceProviderGenerator;
use App\Ship\Core\Generator\Commands\SubActionGenerator;
use App\Ship\Core\Generator\Commands\TaskGenerator;
use App\Ship\Core\Generator\Commands\TestFunctionalTestGenerator;
use App\Ship\Core\Generator\Commands\TestTestCaseGenerator;
use App\Ship\Core\Generator\Commands\TestUnitTestGenerator;
use App\Ship\Core\Generator\Commands\TransformerGenerator;
use App\Ship\Core\Generator\Commands\TransporterGenerator;
use App\Ship\Core\Generator\Commands\ValueGenerator;
use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // all generators ordered by name
        $this->registerGenerators([
            ActionGenerator::class,
            ConfigurationGenerator::class,
            ContainerGenerator::class,
            ContainerApiGenerator::class,
            ContainerWebGenerator::class,
            ControllerGenerator::class,
            EventGenerator::class,
            EventHandlerGenerator::class,
            ExceptionGenerator::class,
            JobGenerator::class,
            MailGenerator::class,
            MigrationGenerator::class,
            ModelGenerator::class,
            NotificationGenerator::class,
            ReadmeGenerator::class,
            RepositoryGenerator::class,
            RequestGenerator::class,
            RouteGenerator::class,
            SeederGenerator::class,
            ServiceProviderGenerator::class,
            SubActionGenerator::class,
            TestFunctionalTestGenerator::class,
            TestTestCaseGenerator::class,
            TestUnitTestGenerator::class,
            TaskGenerator::class,
            TransformerGenerator::class,
            ValueGenerator::class,
            TransporterGenerator::class,
            FactoryGenerator::class,
        ]);
    }

    /**
     * Register the generators.
     */
    private function registerGenerators(array $classes): void
    {
        foreach ($classes as $class) {
            $lowerClass = strtolower($class);

            $this->app->singleton("command.porto.$lowerClass", fn ($app) => $app[$class]);

            $this->commands("command.porto.$lowerClass");
        }
    }
}
