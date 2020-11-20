<?php

namespace Notify\Middleware;

use Notify\Envelope\Envelope;

interface MiddlewareInterface
{
    /**
     * @param \Notify\Envelope\Envelope $envelope
     * @param callable                  $next
     *
     * @return \Notify\Envelope\Envelope
     */
    public function handle(Envelope $envelope, callable $next);
}
