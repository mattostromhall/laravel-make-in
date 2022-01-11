<?php

namespace MattOstromHall\MakeIn;

use Illuminate\Support\Str;

class ModelMakeIn extends MakeIn
{
    public function defaultDirectory(): string
    {
        $appPath = app()->path();

        return $this->modelDirectoryExists()
            ? $appPath . '/Models/'
            : $appPath . '/';
    }

    public function defaultNamespace(): string
    {
        $rootNamespace = app()->getNamespace();

        return $this->modelDirectoryExists()
            ? $rootNamespace . '\\Models'
            : $rootNamespace;
    }

    public function basePath(): string
    {
        return Str::endsWith(config('make-in.paths.base.model'), '/')
            ? config('make-in.paths.base.model')
            : config('make-in.paths.base.model') . '/';
    }
}