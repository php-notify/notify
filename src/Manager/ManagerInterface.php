<?php

namespace Notify\Manager;

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
     * Register a custom driver creator.
     *
     * @param string          $alias
     * @param \Closure|object $driver
     *
     * @return $this
     */
    public function addDriver($alias, $driver);
}
