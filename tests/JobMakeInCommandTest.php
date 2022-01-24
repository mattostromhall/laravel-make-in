<?php

use Illuminate\Filesystem\Filesystem;
use MattOstromHall\MakeIn\Commands\JobMakeInCommand;
use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->fileSystem = app(Filesystem::class);
});

it('creates a job, moves it to the requested path and updates the namespace', function () {
    artisan(JobMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'Test/SubTest/'
    ])
        ->expectsOutput('Job created in ' . config('make-in.path.base.job') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.job') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.job') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.job') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.job') . 'Test/Subtest/Test.php')
    );
});

it('will format the path provided to follow directory case convention', function () {
    artisan(JobMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'tEst/subtest/'
    ])
        ->expectsOutput('Job created in ' . config('make-in.path.base.job') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.job') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.job') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.job') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.job') . 'Test/Subtest/Test.php')
    );
});

it('will create the job in the base location if no path is provided', function () {
    artisan(JobMakeInCommand::class, [
        'name' => 'Test',
        '--path' => null
    ])
        ->expectsOutput('Job created in ' . config('make-in.path.base.job') . 'Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.job'))
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.job') . 'Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.job'),
        $this->fileSystem->get(config('make-in.path.base.job') . 'Test.php')
    );
});
