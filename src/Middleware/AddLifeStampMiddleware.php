<?php

namespace Notify\Middleware;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\LifeStamp;

final class AddLifeStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Notify\Envelope\Stamp\LifeStamp')) {
            $envelope->withStamp(new LifeStamp(1));
        }

        return $next($envelope);
    }
}
