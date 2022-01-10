<?php

namespace MattOstromHall\MakeIn\Commands;

use Illuminate\Console\Command;

class ModelMakeInCommand extends Command
{
    public $signature = 'make:model-in {name} {--c|controller} {--m|migration}';

    public $description = 'Create a new Eloquent model class, move it to a specified location and update the namespace';

    public function handle(): int
    {
        $modelName = $this->argument('name');

        $this->call('make:model', [
            'name' => $modelName,
            '--controller' => $this->option('controller'),
            '--migration' => $this->option('migration')
        ]);

        $this->comment('All done');

        return self::SUCCESS;
    }
}
