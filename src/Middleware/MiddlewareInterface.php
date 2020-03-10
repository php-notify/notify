<?php

namespace Yoeunes\Notify\Middleware;

use Yoeunes\Notify\Envelope\Envelope;

interface MiddlewareInterface
{
    /**
     * @param  \Yoeunes\Notify\Envelope\Envelope        $envelope
     * @param  \Yoeunes\Notify\Middleware\StackInterface  $stack
     *
     * @return \Yoeunes\Notify\Envelope\Envelope
     */
    public function handle(Envelope $envelope, StackInterface $stack);
}
