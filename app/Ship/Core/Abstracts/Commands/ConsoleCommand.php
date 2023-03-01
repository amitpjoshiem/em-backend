<?php

namespace App\Ship\Core\Abstracts\Commands;

use Illuminate\Console\Command as LaravelCommand;

abstract class ConsoleCommand extends LaravelCommand
{
    /**
     * The type of this controller. This will be accessible mirrored in the Actions.
     * Giving each Action the ability to modify it's internal business logic based on the UI type that called it.
     */
    public string $ui = 'cli';
}
