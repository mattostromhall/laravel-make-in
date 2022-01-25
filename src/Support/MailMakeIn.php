<?php

namespace MattOstromHall\MakeIn\Support;

class MailMakeIn extends MakeIn
{
    protected string $type = 'mail';

    protected function defaultDirectory(): string
    {
        return app_path('Mail') . '/';
    }

    protected function defaultNamespace(): string
    {
        return app()->getNamespace() . 'Mail';
    }
}
