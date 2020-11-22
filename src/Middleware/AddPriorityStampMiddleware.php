<?php

namespace Notify\Middleware;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\PriorityStamp;

final class AddPriorityStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Notify\Envelope\Stamp\PriorityStamp')) {
            $envelope->withStamp(new PriorityStamp(0));
        }

        return $next($envelope);
    }
}
