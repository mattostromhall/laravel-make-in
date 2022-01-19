<?php

namespace MattOstromHall\MakeIn\Commands;

use Illuminate\Console\Command;
use MattOstromHall\MakeIn\Support\CommandMakeIn;

class CommandMakeInCommand extends Command
{
    public $signature = 'make:command-in {name} {--p|path=}';

    public $description = 'Create a new command class, move it to a specified location and update the namespace';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $makeIn = app()->makeWith(CommandMakeIn::class, [
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

        $this->info('Command created in ' . $makeIn->movedTo());
        $this->info('Created with Namespace ' . $makeIn->namespaceTo());

        return self::SUCCESS;
    }
}
