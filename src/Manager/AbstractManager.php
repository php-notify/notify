<?php

namespace Notify\Manager;

use InvalidArgumentException;
use Notify\Config\ConfigInterface;

abstract class AbstractManager implements ManagerInterface
{
    /**
     * The array of created "drivers".
     *
     * @var array<object>
     */
    protected $drivers = array();

    /**
     * @var \Notify\Config\ConfigInterface
     */
    protected $config;

    /**
     * @param \Notify\Config\ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function make($name = null, array $context = array())
    {
        $name = $name ?: $this->getDefaultDriver();

        if (is_array($name)) {
            $context = $name;
            $name = null;
        }

        foreach ($this->drivers as $driver) {
            if ($driver->supports($name, $context)) {
                return $driver;
            }
        }

        throw new InvalidArgumentException(sprintf('Driver [%s] not supported.', $name));
    }

    /**
     * {@inheritdoc}
     */
    public function addDriver($driver)
    {
        $this->drivers[] = $driver;

        return $this;
    }

    /**
     * @return string|null
     */
    protected function getDefaultDriver()
    {
        return null;
    }

    /**
     * @return \Notify\Config\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
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
}
