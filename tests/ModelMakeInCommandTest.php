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
        ->expectsQuestion('What is the path? (press enter for default)', null)
        ->expectsOutput('Model created in ' . config('make-in.path.base.model') . 'Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.model'))
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.model') . 'Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.model'),
        $this->fileSystem->get(config('make-in.path.base.model') . 'Test.php')
    );
});

it('prompts for a name and a path if they are not provided', function () {
    artisan(ModelMakeInCommand::class)
        ->expectsQuestion('What is the model called?', 'Test')
        ->expectsQuestion('What is the path? (press enter for default)', 'Test/SubTest/')
        ->expectsOutput('Model created in ' . config('make-in.path.base.model') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.model') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.model') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.model') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.model') . 'Test/Subtest/Test.php')
    );
});
