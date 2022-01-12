<?php

namespace MattOstromHall\MakeIn\Support;

use Illuminate\Support\Str;

class ModelMakeIn extends MakeIn
{
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
}