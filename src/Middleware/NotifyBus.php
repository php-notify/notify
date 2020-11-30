<?php

namespace Notify\Middleware;

use Notify\Envelope\Envelope;

final class NotifyBus
{
    /**
     * @var \Notify\Middleware\MiddlewareInterface[]
     */
    private $middlewares;

    /**
     * Executes the given command and optionally returns a value
     *
     * @param \Notify\Envelope\Envelope|\Notify\Notification\NotificationInterface $envelope
     * @param array                                                                $stamps
     *
     * @return mixed
     */
    public function dispatch($envelope, $stamps = array())
    {
        $envelope = Envelope::wrap($envelope, $stamps);

        $middlewareChain = $this->createExecutionChain();

        $middlewareChain($envelope);

        return $envelope;
    }

    /**
     * @param \Notify\Middleware\MiddlewareInterface $middleware
     *
     * @return $this
     */
    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * @return callable
     */
    private function createExecutionChain()
    {
        $lastCallable = static function () {
            // the final callable is a no-op
        };

        $middlewares = $this->middlewares;

        while ($middleware = array_pop($middlewares)) {
            $lastCallable = static function ($command) use ($middleware, $lastCallable) {
                return $middleware->handle($command, $lastCallable);
            };
        }

        return $lastCallable;
    }
}
