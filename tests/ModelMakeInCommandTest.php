<?php

use MattOstromHall\MakeIn\Commands\ModelMakeInCommand;
use function Pest\Laravel\artisan;

it('creates a model', function() {
    artisan(ModelMakeInCommand::class, [
        'name' => 'Test',
        '--in' => 'Test'
    ])->assertSuccessful();
});
