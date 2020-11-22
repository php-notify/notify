<?php

namespace Notify\Middleware;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\UuidStamp;

final class AddUuidStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Notify\Envelope\Stamp\UuidStamp')) {
            $envelope->withStamp(new UuidStamp());
        }

        return $next($envelope);
    }
}
