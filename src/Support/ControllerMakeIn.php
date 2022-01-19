<?php

namespace MattOstromHall\MakeIn\Support;

class ControllerMakeIn extends MakeIn
{
    protected string $type = 'controller';

    protected function defaultDirectory(): string
    {
        return app_path('Http/Controllers') . '/';
    }

    protected function defaultNamespace(): string
    {
        return app()->getNamespace() . 'Http\Controllers';
    }

    protected function updateFileContents()
    {
        parent::updateFileContents();

        $this->fileSystem->replaceInFile(
            'use Illuminate\Http\Request;',
            "use " . config("make-in.namespace.base.$this->type") . "\Controller;\nuse Illuminate\Http\Request;",
            $this->movedTo()
        );
    }
}
