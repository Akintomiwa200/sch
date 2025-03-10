<?php

namespace Dotenv\Repository;

interface RepositoryInterface
{
    /**
     * Set a key-value pair in the repository.
     *
     * @param string $key   The environment variable name.
     * @param string $value The value of the environment variable.
     */
    public function set(string $key, string $value): void;

    /**
     * Get a value for the given key from the repository.
     *
     * @param string $key The environment variable name.
     * @return string|null The value of the environment variable or null if not found.
     */
    public function get(string $key): ?string;
}

namespace Dotenv\Repository\Adapter;

use Dotenv\Repository\RepositoryInterface;

/**
 * An adapter that stores environment variables in PHP's environment variables using `putenv()`.
 */
class EnvConstAdapter implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function set(string $key, string $value): void
    {
        putenv("$key=$value");  // Store in the environment
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key): ?string
    {
        return getenv($key);  // Retrieve from the environment
    }
}

namespace Dotenv\Repository;

/**
 * A simple repository that interacts with PHP's environment variable store.
 */
class Repository implements RepositoryInterface
{
    /**
     * The environment variable adapter.
     *
     * @var RepositoryInterface
     */
    protected $adapter;

    /**
     * Constructor.
     *
     * @param RepositoryInterface $adapter The adapter to interact with.
     */
    public function __construct(RepositoryInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, string $value): void
    {
        $this->adapter->set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key): ?string
    {
        return $this->adapter->get($key);
    }
}
