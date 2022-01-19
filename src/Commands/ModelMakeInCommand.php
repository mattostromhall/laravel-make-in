<?php

namespace MattOstromHall\MakeIn\Commands;

use Illuminate\Console\Command;
use MattOstromHall\MakeIn\Support\ControllerMakeIn;
use MattOstromHall\MakeIn\Support\ModelMakeIn;

class ModelMakeInCommand extends Command
{
    public $signature = 'make:model-in {name} {--p|path=} {--c|controller} {--m|migration}';

    public $description = 'Create a new Eloquent model class, move it to a specified location and update the namespace';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $makeIn = app()->makeWith(ModelMakeIn::class, [
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

        if ($this->option('controller')) {
            if ($this->confirm('Mirror path for controller?', true)) {
                $this->moveController();
            }
        }

        $moved = $makeIn->move();

        if (!$moved) {
            return self::FAILURE;
        }

        $this->info('Model created in ' . $makeIn->movedTo());
        $this->info('Created with Namespace ' . $makeIn->namespaceTo());

        return self::SUCCESS;
    }

    protected function moveController(): int
    {
        $controllerMakeIn = app()->makeWith(ControllerMakeIn::class, [
            'name' => $this->argument('name') . 'Controller',
            'path' => $this->option('path'),
            'options' => $this->options()
        ]);

        $this->info('Controller created in ' . $controllerMakeIn->movedTo());
        $this->info('Created with Namespace ' . $controllerMakeIn->namespaceTo());

        return $controllerMakeIn->move();
    }
}
