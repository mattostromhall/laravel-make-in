<?php

namespace MattOstromHall\MakeIn\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use MattOstromHall\MakeIn\Support\ModelMakeIn;

class ModelMakeInCommand extends Command
{
    public $signature = 'make:model-in {name} {--p|path=} {--c|controller} {--m|migration}';

    public $description = 'Create a new Eloquent model class, move it to a specified location and update the namespace';

    public function __construct(protected Filesystem $fileSystem)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $makeIn = app()->makeWith(ModelMakeIn::class, [
            'name' => $this->argument('name'),
            'path' => $this->option('path'),
        ]);

        if ($this->option('controller')) {
            if ($this->confirm('Mirror path for controller?', true)) {
                $this->makeController();
            }
        }

        $makeResponse = $this->makeModel();
        if ($makeResponse === 1) {
            return self::FAILURE;
        }
        if ($makeResponse === 2) {
            return self::INVALID;
        }

        $moved = $makeIn->move();
        if ($moved) {
            $this->info('Model moved to ' . $makeIn->movedTo());
            $this->info('Namespace updated to ' . $makeIn->namespaceTo());
        }

        return self::SUCCESS;
    }

    protected function makeModel(): int
    {
        return $this->call('make:model', [
            'name' => $this->argument('name'),
            '--controller' => $this->option('controller'),
            '--migration' => $this->option('migration'),
        ]);
    }

    protected function makeController(): int
    {
        return $this->call('make:controller-in', [
            'name' => $this->argument('name'),
            '--path' => $this->option('path'),
        ]);
    }
}
