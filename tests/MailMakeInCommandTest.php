<?php

use Illuminate\Filesystem\Filesystem;
use MattOstromHall\MakeIn\Commands\MailMakeInCommand;
use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->fileSystem = app(Filesystem::class);
});

it('creates a mail, moves it to the requested path and updates the namespace', function () {
    artisan(MailMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'Test/SubTest/'
    ])
        ->expectsOutput('Mail created in ' . config('make-in.path.base.mail') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.mail') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.mail') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.mail') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.mail') . 'Test/Subtest/Test.php')
    );
});

it('will format the path provided to follow directory case convention', function () {
    artisan(MailMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'tEst/subtest/'
    ])
        ->expectsOutput('Mail created in ' . config('make-in.path.base.mail') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.mail') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.mail') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.mail') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.mail') . 'Test/Subtest/Test.php')
    );
});

it('will create the mail in the base location if no path is provided', function () {
    artisan(MailMakeInCommand::class, [
        'name' => 'Test',
        '--path' => null
    ])
        ->expectsOutput('Mail created in ' . config('make-in.path.base.mail') . 'Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.mail'))
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.mail') . 'Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.mail'),
        $this->fileSystem->get(config('make-in.path.base.mail') . 'Test.php')
    );
});
