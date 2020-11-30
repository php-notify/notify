<?php

namespace Notify\Middleware;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\ReplayStamp;

final class AddReplayStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Notify\Envelope\Stamp\ReplayStamp')) {
            $envelope->withStamp(new ReplayStamp(1));
        }

        return $next($envelope);
    }
}
