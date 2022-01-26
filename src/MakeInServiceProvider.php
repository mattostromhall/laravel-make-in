<?php

namespace MattOstromHall\MakeIn;

use MattOstromHall\MakeIn\Commands\CommandMakeInCommand;
use MattOstromHall\MakeIn\Commands\ControllerMakeInCommand;
use MattOstromHall\MakeIn\Commands\JobMakeInCommand;
use MattOstromHall\MakeIn\Commands\MailMakeInCommand;
use MattOstromHall\MakeIn\Commands\ModelMakeInCommand;
use MattOstromHall\MakeIn\Commands\RequestMakeInCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MakeInServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-make-in')
            ->hasConfigFile()
            ->hasCommands(
                CommandMakeInCommand::class,
                ControllerMakeInCommand::class,
                JobMakeInCommand::class,
                MailMakeInCommand::class,
                ModelMakeInCommand::class,
                RequestMakeInCommand::class
            );
    }
}
