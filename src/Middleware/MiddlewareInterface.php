<?php

namespace Yoeunes\Notify\Middleware;

use Yoeunes\Notify\Envelope\Envelope;

interface MiddlewareInterface
{
    /**
     * @param \Yoeunes\Notify\Envelope\Envelope $envelope
     * @param callable                          $next
     *
     * @return \Yoeunes\Notify\Envelope\Envelope
     */
    public function handle(Envelope $envelope, callable $next);
}
