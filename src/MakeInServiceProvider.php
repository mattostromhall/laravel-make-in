<?php

namespace MattOstromHall\MakeIn;

use MattOstromHall\MakeIn\Commands\ModelMakeInCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MakeInServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-make-in')
            ->hasConfigFile()
            ->hasCommands(ModelMakeInCommand::class);
    }
}
