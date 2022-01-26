<?php

use Illuminate\Filesystem\Filesystem;
use MattOstromHall\MakeIn\Commands\RequestMakeInCommand;
use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->fileSystem = app(Filesystem::class);
});

it('creates a request, moves it to the requested path and updates the namespace', function () {
    artisan(RequestMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'Test/SubTest/'
    ])
        ->expectsOutput('Request created in ' . config('make-in.path.base.request') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.request') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.request') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.request') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.request') . 'Test/Subtest/Test.php')
    );
});

it('will format the path provided to follow directory case convention', function () {
    artisan(RequestMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'tEst/subtest/'
    ])
        ->expectsOutput('Request created in ' . config('make-in.path.base.request') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.request') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.request') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.request') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.request') . 'Test/Subtest/Test.php')
    );
});

it('will create the request in the base location if no path is provided', function () {
    artisan(RequestMakeInCommand::class, [
        'name' => 'Test',
        '--path' => null
    ])
        ->expectsOutput('Request created in ' . config('make-in.path.base.request') . 'Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.request'))
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.request') . 'Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.request'),
        $this->fileSystem->get(config('make-in.path.base.request') . 'Test.php')
    );
});
