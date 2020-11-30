<?php

namespace Notify\Middleware;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\RenderedAtStamp;

final class AddRenderedAtStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Notify\Envelope\Stamp\RenderedAtStamp')) {
            $envelope->withStamp(new RenderedAtStamp());
        }

        return $next($envelope);
    }
}
