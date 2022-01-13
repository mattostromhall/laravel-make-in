<?php

namespace MattOstromHall\MakeIn\Support;

class ModelMakeIn extends MakeIn
{
    protected string $type = 'model';

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
            ? $rootNamespace . 'Models'
            : $rootNamespace;
    }
}
