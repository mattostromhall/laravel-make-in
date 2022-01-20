<?php

namespace MattOstromHall\MakeIn\Support;

use Illuminate\Support\Str;

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

    protected function updateFileContents()
    {
        parent::updateFileContents();

        $this->registerCommand();
    }

    protected function registerCommand()
    {
        $this->fileSystem->replaceInFile(
            '$this->load' . "(__DIR__.'/Commands');",
            '$this->load' . "(__DIR__.'/Commands');\n\t\t" . '$this->load(' . $this->loadFrom() . "');",
            app_path('Console') . '/Kernel.php'
        );
    }

    protected function loadFrom(): string
    {
        return Str::of($this->basePath() . $this->sanitisedPath())
            ->replace(app_path(), "__DIR__.'/..")
            ->rtrim('/');
    }
}
