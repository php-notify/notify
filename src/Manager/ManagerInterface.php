<?php

namespace Yoeunes\Notify\Manager;

interface ManagerInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null $driver
     *
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    public function make($driver = null);

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
}
