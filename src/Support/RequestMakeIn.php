<?php

namespace MattOstromHall\MakeIn\Support;

class RequestMakeIn extends MakeIn
{
    protected string $type = 'request';

    protected function defaultDirectory(): string
    {
        return app_path('Http/Requests') . '/';
    }

    protected function defaultNamespace(): string
    {
        return app()->getNamespace() . 'Http\Requests';
    }
}
