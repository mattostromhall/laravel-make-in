<?php

namespace MattOstromHall\MakeIn\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

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
        $makeResponse = $this->makeModel();
        if ($makeResponse === 1) {
            return self::FAILURE;
        }
        if ($makeResponse === 2) {
            return self::INVALID;
        }

        if ($this->pathProvided()) {
            $this->fileSystem->move($this->createdPath(), $this->requestedPath());
            $this->info('Model moved to ' . $this->requestedPath());
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

    protected function modelDirectoryExists(): bool
    {
        return is_dir(app_path('Models'));
    }

    protected function defaultDirectory(): string
    {
        $appPath = app()->path();

        return $this->modelDirectoryExists()
            ? $appPath . '/Models/'
            : $appPath . '/';
    }

    protected function defaultNamespace(): string
    {
        $rootNamespace = app()->getNamespace();

        return $this->modelDirectoryExists()
            ? $rootNamespace . '\\Models'
            : $rootNamespace;
    }

    protected function basePath(): string
    {
        return Str::endsWith(config('make-in.paths.base.model'), '/')
            ? config('make-in.paths.base.model')
            : config('make-in.paths.base.model') . '/';
    }

    protected function pathProvided(): bool
    {
        return $this->option('path') !== null;
    }

    protected function createdPath(): string
    {
        return $this->defaultDirectory() . $this->argument('name') . '.php';
    }

    protected function requestedPath(): string|null
    {
        $sanitisedPath = Str::endsWith($this->option('path'), '/')
            ? $this->option('path')
            : $this->option('path') . '/';

        return $this->basePath() . $sanitisedPath . $this->argument('name') . '.php';
    }
}
