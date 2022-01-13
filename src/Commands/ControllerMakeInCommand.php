<?php

namespace MattOstromHall\MakeIn\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use MattOstromHall\MakeIn\Support\ControllerMakeIn;

class ControllerMakeInCommand extends Command
{
    public $signature = 'make:controller-in {name} {--p|path=}';

    public $description = 'Create a new controller class, move it to a specified location and update the namespace';

    public function __construct(protected Filesystem $fileSystem)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $makeIn = app()->makeWith(ControllerMakeIn::class, [
            'name' => $this->argument('name'),
            'path' => $this->option('path'),
        ]);

        $makeResponse = $this->makeController();
        if ($makeResponse === 1) {
            return self::FAILURE;
        }
        if ($makeResponse === 2) {
            return self::INVALID;
        }

        $moved = $makeIn->move();
        if ($moved) {
            $this->info('Controller moved to ' . $makeIn->movedTo());
            $this->info('Namespace updated to ' . $makeIn->namespaceTo());
        }

        return self::SUCCESS;
    }

    protected function makeController(): int
    {
        return $this->call('make:controller', [
            'name' => $this->argument('name')
        ]);
    }
}
