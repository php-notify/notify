<?php

namespace Notify\Manager;

use InvalidArgumentException;

abstract class AbstractManager implements ManagerInterface
{
    /**
     * The array of created "drivers".
     *
     * @var array<string, object>
     */
    protected $drivers = array();

    /**
     * {@inheritdoc}
     */
    public function addDriver($alias, $driver)
    {
        $this->drivers[$alias] = $driver;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function make($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();

        if (null === $driver) {
            throw new InvalidArgumentException(sprintf('Unable to resolve NULL driver for [%s].', get_called_class()));
        }

        if (!isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array(array($this->make(), $method), $parameters);
    }

    /**
     * Create a new driver instance.
     *
     * @param string $driver
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function createDriver($driver)
    {
        $method = 'create'.str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', $driver))).'Driver';

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new InvalidArgumentException(sprintf('Driver [%s] not supported.', $driver));
    }

    /**
     * @return string|null
     */
    protected function getDefaultDriver()
    {
        return null;
    }
}
