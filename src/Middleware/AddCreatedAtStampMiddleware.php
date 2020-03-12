<?php

namespace Yoeunes\Notify\Middleware;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\CreatedAtStamp;

final class AddCreatedAtStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Yoeunes\Notify\Envelope\Stamp\CreatedAtStamp')) {
            $envelope->with(new CreatedAtStamp());
        }

        return $next($envelope);
    }
}
