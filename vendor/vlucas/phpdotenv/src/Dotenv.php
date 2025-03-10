<?php
namespace Dotenv;

use Dotenv\Exception\InvalidFileException;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\RepositoryInterface;
use Dotenv\Loader;

class Dotenv
{
    protected $loader;
    protected $repository;

    public function __construct(string $path, string $file = '.env')
    {
        $this->repository = new RepositoryInterface(new EnvConstAdapter());
        $this->loader = new Loader($path, $file, $this->repository);
    }

    public function load(): void
    {
        $this->loader->load();
    }

    public function loadWithOptions(array $options): void
    {
        $this->loader->loadWithOptions($options);
    }
}
