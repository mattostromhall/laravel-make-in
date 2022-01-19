<?php

namespace MattOstromHall\MakeIn\Support;

class CommandMakeIn extends MakeIn
{
    protected string $type = 'command';

    protected function defaultDirectory(): string
    {
        return app_path('Console/Commands') . '/';
    }

    protected function defaultNamespace(): string
    {
        return app()->getNamespace() . 'Console\Commands';
    }
}
