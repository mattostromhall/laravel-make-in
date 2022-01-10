<?php

namespace MattOstromHall\MakeIn;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MattOstromHall\MakeIn\Commands\ModelMakeInCommand;

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
