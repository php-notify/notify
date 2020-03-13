<?php

namespace Yoeunes\Notify\Manager;

use Yoeunes\Notify\Config\ConfigInterface;

abstract class AbstractManager implements ManagerInterface
{
    /**
     * The config instance.
     *
     * @var \Yoeunes\Notify\Config\ConfigInterface
     */
    protected $config;

    /**
     * The array of created "drivers".
     *
     * @var array<string, object>
     */
    protected $drivers = array();

    /**
     * Create a new manager instance.
     *
     * @param \Yoeunes\Notify\Config\ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function make($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();

        if (is_null($driver)) {
            throw new \InvalidArgumentException(sprintf(
                'Unable to resolve NULL driver for [%s].', get_called_class()
            ));
        }

        if (!isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultDriver()
    {
        return $this->config->get($this->getConfigKeyForDefaultDriver());
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
        $config = $this->getDriverConfig($driver);

        if (isset($config['driver'])) {
            $driver = $config['driver'];
        }

        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver, $config);
        }

        $method = 'create' . str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', $driver))) . 'Driver';

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new \InvalidArgumentException(sprintf("Driver [%s] not supported.", $driver));
    }

    /**
     * {@inheritdoc}
     */
    public function extend($driver, $resolver)
    {
        $this->customCreators[$driver] = $resolver;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * {@inheritdoc}
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
