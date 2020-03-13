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
     * The registered custom driver creators.
     *
     * @var array<string, callable>
     */
    protected $customCreators = array();

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
    public function driver($driver = null)
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
    public function getDefaultDriver()
    {
        $root = null !== $this->getRootConfig() ? '.' : '';

        return $this->config->get($root . 'default');
    }

    /**
     * @inheritDoc
     */
    public function getRootConfig()
    {
        return null;
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
     * @inheritDoc
     */
    public function getDriversFromConfig()
    {
        $root = null !== $this->getRootConfig() ? '.' : '';

        return $this->config->get($root . 'drivers', array());
    }

    /**
     * Get the configuration for a driver.
     *
     * @param string $driver
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function getDriverConfig($driver)
    {
        $drivers = $this->getDriversFromConfig();

        if (!isset($drivers[$driver]) || !is_array($drivers[$driver])) {
            throw new \InvalidArgumentException(sprintf('Driver [%s] not configured', $driver));
        }

        $config = $drivers[$driver];

        return $config + array('driver' => $driver);
    }

    /**
     * {@inheritdoc}
     */
    public function callCustomCreator($driver, array $config = array())
    {
        return $this->customCreators[$driver]($config);
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
        return call_user_func_array(array($this->driver(), $method), $parameters);
    }
}
