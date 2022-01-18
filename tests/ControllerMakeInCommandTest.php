<?php

use Illuminate\Filesystem\Filesystem;
use MattOstromHall\MakeIn\Commands\ControllerMakeInCommand;
use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->fileSystem = app(Filesystem::class);
});

it('creates a controller, moves it to the requested path, updates the namespace and adds the use controller statement', function () {
    artisan(ControllerMakeInCommand::class, [
        'name' => 'TestController',
        '--path' => 'Test/SubTest/'
    ])
        ->expectsOutput('Controller created in ' . config('make-in.path.base.controller') . 'Test/Subtest/TestController.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.controller') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.controller') . 'Test/Subtest/TestController.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.controller') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.controller') . 'Test/Subtest/TestController.php')
    );
    $this->assertStringContainsString(
        'use App\Http\Controllers\Controller;',
        $this->fileSystem->get(config('make-in.path.base.controller') . 'Test/Subtest/TestController.php')
    );
});

it('will format the path provided to follow directory case convention', function () {
    artisan(ControllerMakeInCommand::class, [
        'name' => 'TestController',
        '--path' => 'tEst/subtest/'
    ])
        ->expectsOutput('Controller created in ' . config('make-in.path.base.controller') . 'Test/Subtest/TestController.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.controller') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.controller') . 'Test/Subtest/TestController.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.controller') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.controller') . 'Test/Subtest/TestController.php')
    );
});

it('will create the controller in the base location if no path is provided', function () {
    artisan(ControllerMakeInCommand::class, [
        'name' => 'TestController',
        '--path' => null
    ])
        ->expectsOutput('Controller created in ' . config('make-in.path.base.controller') . 'TestController.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.controller'))
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.controller') . 'TestController.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.controller'),
        $this->fileSystem->get(config('make-in.path.base.controller') . 'TestController.php')
    );
});
