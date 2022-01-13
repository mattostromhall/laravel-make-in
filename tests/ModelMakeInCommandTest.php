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
        ->expectsOutput('Model moved to ' . config('make-in.path.base.model') . 'Test/Subtest/Test.php')
        ->expectsOutput('Namespace updated to ' . config('make-in.namespace.base.model') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.model') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.model') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.model') . 'Test/Subtest/Test.php')
    );
});
