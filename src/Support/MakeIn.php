<?php

namespace MattOstromHall\MakeIn\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

abstract class MakeIn
{
    protected string $type;

    public function __construct(
        protected Filesystem  $fileSystem,
        protected string      $name,
        protected string|null $path,
        protected array       $options = []
    ) {
        //
    }

    abstract protected function defaultDirectory(): string;

    abstract protected function defaultNamespace(): string;

    public function make(): int
    {
        return Artisan::call(
            "make:$this->type",
            array_merge(
            ['name' => $this->name],
            $this->sanitisedOptions()
        )
        );
    }

    protected function sanitisedOptions(): array
    {
        return collect(Arr::except($this->options, ['path', 'help', 'quiet', 'version']))
            ->flatMap(function ($option, $key) {
                return ["--$key" => $option];
            })
            ->toArray();
    }

    protected function basePath(): string
    {
        return Str::endsWith(config("make-in.path.base.$this->type"), '/')
            ? config("make-in.path.base.$this->type")
            : config("make-in.path.base.$this->type") . '/';
    }

    protected function baseNamespace(): string
    {
        return Str::of(config("make-in.namespace.base.$this->type"))->trim('\\');
    }

    protected function makeDirectories(string $path)
    {
        if ($this->fileSystem->isDirectory($path)) {
            return;
        }

        $this->fileSystem->makeDirectory($path, 0777, true, true);
    }

    protected function createdPath(): string
    {
        return $this->defaultDirectory() . $this->name . '.php';
    }

    protected function sanitisedPath(): string
    {
        $path = Str::of($this->path)
            ->replace('/', ' ')
            ->split('/[\s]+/')
            ->map(fn ($str) => Str::of($str)->lower()->studly())
            ->join('/');

        return Str::endsWith($path, '/') || $path === ''
            ? $path
            : $path . '/';
    }

    protected function requestedPath(): string|null
    {
        $fullPath = $this->basePath() . $this->sanitisedPath();

        $this->makeDirectories($fullPath);

        return $fullPath . $this->name . '.php';
    }

    protected function deriveNamespaceFromPath(): string
    {
        return $this->path !== null
            ? Str::of($this->sanitisedPath())
                ->trim('/')
                ->replace('/', '\\')
                ->prepend('\\')
            : '';
    }

    protected function requestedNamespace(): string
    {
        return $this->baseNamespace() . $this->deriveNamespaceFromPath();
    }

    public function move(): bool
    {
        $moved = $this->fileSystem->move($this->createdPath(), $this->requestedPath());

        if ($moved) {
            $this->updateNamespace();
        }

        return $moved;
    }

    protected function updateNamespace()
    {
        $this->fileSystem->replaceInFile($this->defaultNamespace(), $this->requestedNamespace(), $this->movedTo());
    }

    public function movedTo(): string
    {
        return $this->requestedPath();
    }

    public function namespaceTo(): string
    {
        return $this->requestedNamespace();
    }
}
