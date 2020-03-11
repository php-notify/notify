<?php

namespace Yoeunes\Notify\Middleware;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\PriorityStamp;

final class AddPriorityStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Yoeunes\Notify\Envelope\Stamp\PriorityStamp')) {
            $envelope->with(new PriorityStamp(0));
        }

        return $next($envelope);
    }
}
