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
}