<?php

namespace Notify\Middleware;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\CreatedAtStamp;

final class AddCreatedAtStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Notify\Envelope\Stamp\CreatedAtStamp')) {
            $envelope->with(new CreatedAtStamp());
        }

        return $next($envelope);
    }
}
