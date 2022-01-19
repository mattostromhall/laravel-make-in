<?php

namespace MattOstromHall\MakeIn\Commands;

use Illuminate\Console\Command;
use MattOstromHall\MakeIn\Support\ControllerMakeIn;

class ControllerMakeInCommand extends Command
{
    public $signature = 'make:controller-in {name} {--p|path=} {--api} {--i|invokable} {--r|resource}';

    public $description = 'Create a new controller class, move it to a specified location and update the namespace';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $makeIn = app()->makeWith(ControllerMakeIn::class, [
            'name' => $this->argument('name'),
            'path' => $this->option('path'),
            'options' => $this->options()
        ]);

        $makeResponse = $makeIn->make();
        if ($makeResponse === 1) {
            return self::FAILURE;
        }
        if ($makeResponse === 2) {
            return self::INVALID;
        }

        $moved = $makeIn->move();
        if (!$moved) {
            return self::FAILURE;
        }

        $this->info('Controller created in ' . $makeIn->movedTo());
        $this->info('Created with Namespace ' . $makeIn->namespaceTo());

        return self::SUCCESS;
    }
}
