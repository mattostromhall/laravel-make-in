<?php

namespace MattOstromHall\MakeIn\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class MakeIn
{
    public function __construct(
        protected Filesystem $fileSystem,
        protected string $name,
        protected string|null $path
    )
    {
        //
    }

    abstract protected function defaultDirectory(): string;

    abstract protected function defaultNamespace(): string;

    abstract protected function basePath(): string;

    protected function pathProvided(): bool
    {
        return $this->path !== null;
    }

    protected function makeDirectories(string $path)
    {
        if ($this->fileSystem->isDirectory($path)) return;

        $this->fileSystem->makeDirectory($path, 0777, true, true);
    }

    protected function createdPath(): string
    {
        return $this->defaultDirectory() . $this->name . '.php';
    }

    protected function requestedPath(): string|null
    {
        $sanitisedPath = Str::endsWith($this->path, '/')
            ? $this->basePath() . $this->path
            : $this->basePath() . $this->path . '/';

        $this->makeDirectories($sanitisedPath);

        return $sanitisedPath . $this->name . '.php';
    }

    public function move(): bool
    {
        if (!$this->pathProvided()) {
            return true;
        }

        return $this->fileSystem->move($this->createdPath(), $this->requestedPath());
    }

    public function movedTo(): string
    {
        return !$this->pathProvided()
            ? $this->createdPath()
            : $this->requestedPath();
    }
}