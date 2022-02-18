<?php

namespace MattOstromHall\MakeIn\Commands;

use Illuminate\Console\Command;
use MattOstromHall\MakeIn\Support\MailMakeIn;

class MailMakeInCommand extends Command
{
    public $signature = 'make:mail-in {name?} {--p|path=} {--f|force} {--m|markdown=}';

    public $description = 'Create a new mail class, move it to a specified location and update the namespace';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $makeIn = app()->makeWith(MailMakeIn::class, [
            'name' => $this->argument('name') ?? $this->ask('What is the mail called?'),
            'path' => $this->option('path') ?? $this->ask('What is the path? (press enter for default)'),
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

        $this->info('Mail created in ' . $makeIn->movedTo());
        $this->info('Created with Namespace ' . $makeIn->namespaceTo());

        return self::SUCCESS;
    }
}
