<?php

namespace Yoeunes\Notify\Manager;

interface ManagerInterface
{
    /**
     * Get the configuration root key.
     *
     * @return string
     */
    public function getRootConfig();

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver();

    /**
     * Get the drivers list from the configuration
     *
     * @return array<string, array>
     */
    public function getDriversFromConfig();

    /**
     * Get a driver instance.
     *
     * @param string|null $driver
     *
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    public function driver($driver = null);

    /**
     * Call a custom driver creator.
     *
     * @param string $driver
     * @param array  $config
     *
     * @return mixed
     */
    public function callCustomCreator($driver, array $config = array());

    /**
     * Register a custom driver creator.
     *
     * @param string          $driver
     * @param \Closure|object $resolver
     *
     * @return $this
     */
    public function extend($driver, $resolver);

    /**
     * Get the config instance.
     *
     * @return \Yoeunes\Notify\Config\ConfigInterface
     */
    public function getConfig();

    /**
     * Get all of the created "drivers".
     *
     * @return array<string, object>
     */
    public function getDrivers();
}
