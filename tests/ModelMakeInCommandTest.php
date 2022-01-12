<?php

use Illuminate\Filesystem\Filesystem;
use MattOstromHall\MakeIn\Commands\ModelMakeInCommand;
use MattOstromHall\MakeIn\Support\ModelMakeIn;
use function Pest\Laravel\artisan;

beforeEach(function() {
   $this->makeIn = app()->makeWith(ModelMakeIn::class, [
       'name' => 'Test',
       'path' => 'Test/SubTest/'
   ]);

   $this->fileSystem = app(Filesystem::class);
});

it('creates a model and moves it to the requested path', function() {
    artisan(ModelMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'Test/SubTest/'
    ])
        ->expectsOutput('Model moved to ' . $this->makeIn->movedTo())
        ->assertSuccessful();

    expect($this->fileSystem->exists($this->makeIn->movedTo()))->toBeTrue();
});
