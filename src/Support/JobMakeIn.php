<?php

namespace MattOstromHall\MakeIn\Support;

class JobMakeIn extends MakeIn
{
    protected string $type = 'job';

    protected function defaultDirectory(): string
    {
        return app_path('Jobs') . '/';
    }

    protected function defaultNamespace(): string
    {
        return app()->getNamespace() . 'Jobs';
    }
}
