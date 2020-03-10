<?php

namespace Yoeunes\Notify\Middleware;

interface StackInterface
{
    /**
     * Returns the next middleware to process a notification.
     *
     * @return \Yoeunes\Notify\Middleware\MiddlewareInterface
     */
    public function next();
}
