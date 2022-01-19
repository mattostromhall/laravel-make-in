<?php

use Illuminate\Filesystem\Filesystem;
use MattOstromHall\MakeIn\Commands\ModelMakeInCommand;
use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->fileSystem = app(Filesystem::class);
});

it('creates a model, moves it to the requested path and updates the namespace', function () {
    artisan(ModelMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'Test/SubTest/'
    ])
        ->expectsOutput('Model created in ' . config('make-in.path.base.model') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.model') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.model') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.model') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.model') . 'Test/Subtest/Test.php')
    );
});

it('will format the path provided to follow directory case convention', function () {
    artisan(ModelMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'tEst/subtest/'
    ])
        ->expectsOutput('Model created in ' . config('make-in.path.base.model') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.model') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.model') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.model') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.model') . 'Test/Subtest/Test.php')
    );
});

it('will create the model in the base location if no path is provided', function () {
    artisan(ModelMakeInCommand::class, [
        'name' => 'Test',
        '--path' => null
    ])
        ->expectsOutput('Model created in ' . config('make-in.path.base.model') . 'Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.model'))
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.model') . 'Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.model'),
        $this->fileSystem->get(config('make-in.path.base.model') . 'Test.php')
    );
});

it('creates a model and controller, moves it to the requested path and updates the namespace', function () {
    artisan(ModelMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'Test/SubTest/',
        '--controller' => true
    ])
        ->expectsConfirmation('Mirror path for controller?', 'yes')
        ->expectsOutput('Controller created in ' . config('make-in.path.base.controller') . 'Test/Subtest/TestController.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.controller') . '\Test\Subtest')
        ->expectsOutput('Model created in ' . config('make-in.path.base.model') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.model') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.model') . 'Test/Subtest/Test.php'))->toBeTrue();
    expect($this->fileSystem->exists(config('make-in.path.base.controller') . 'Test/Subtest/TestController.php'))->toBeTrue();

    $this->assertStringContainsString(
        config('make-in.namespace.base.model') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.model') . 'Test/Subtest/Test.php')
    );
    $this->assertStringContainsString(
        config('make-in.namespace.base.controller') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.controller') . 'Test/Subtest/TestController.php')
    );
    $this->assertStringContainsString(
        'use App\Http\Controllers\Controller;',
        $this->fileSystem->get(config('make-in.path.base.controller') . 'Test/Subtest/TestController.php')
    );
});
