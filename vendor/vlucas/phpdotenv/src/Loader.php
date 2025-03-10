<?php
namespace Dotenv;

class Loader
{
    protected $path;
    protected $file;
    protected $repository;

    public function __construct(string $path, string $file, $repository)
    {
        $this->path = $path;
        $this->file = $file;
        $this->repository = $repository;
    }

    public function load(): void
    {
        $filePath = $this->path . DIRECTORY_SEPARATOR . $this->file;
        if (!file_exists($filePath)) {
            throw new InvalidFileException('Environment file not found at ' . $filePath);
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $this->repository->set($name, $value);
            }
        }
    }
}
