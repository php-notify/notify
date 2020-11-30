<?php

namespace Notify\Manager;

interface ManagerInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null  $name
     * @param array $context
     *
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    public function make($name = null, array $context = array());

    /**
     * Register a custom driver creator.
     *
     * @param \Closure|object $driver
     *
     * @return $this
     */
    public function addDriver($driver);
}
