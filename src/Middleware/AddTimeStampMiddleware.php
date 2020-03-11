<?php

namespace Yoeunes\Notify\Middleware;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\TimeStamp;

final class AddTimeStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Yoeunes\Notify\Envelope\Stamp\TimeStamp')) {
            $envelope->with(new TimeStamp());
        }

        return $next($envelope);
    }
}
