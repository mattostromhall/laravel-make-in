<?php

namespace MattOstromHall\MakeIn;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class MakeIn
{
    public function __construct(
        protected Filesystem $fileSystem,
        protected string $fileName,
        protected string|null $in
    )
    {
        //
    }

    public function modelDirectoryExists(): bool
    {
        return is_dir(app_path('Models'));
    }

    abstract public function defaultDirectory(): string;

    abstract public function defaultNamespace(): string;

    abstract public function basePath(): string;

    public function pathProvided(): bool
    {
        return $this->in !== null;
    }

    public function makeDirectories(string $path)
    {
        if ($this->fileSystem->isDirectory($path)) return;

        $this->fileSystem->makeDirectory($path, 0777, true, true);
    }

    public function createdPath(): string
    {
        return $this->defaultDirectory() . $this->fileName . '.php';
    }

    public function requestedPath(): string|null
    {
        $sanitisedPath = Str::endsWith($this->in, '/')
            ? $this->basePath() . $this->in
            : $this->basePath() . $this->in . '/';

        $this->makeDirectories($sanitisedPath);

        return $sanitisedPath . $this->fileName . '.php';
    }
}