<?php

namespace MattOstromHall\MakeIn\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use MattOstromHall\MakeIn\MakeInServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'MattOstromHall\\MakeIn\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MakeInServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-make-in_table.php.stub';
        $migration->up();
        */
    }
}
