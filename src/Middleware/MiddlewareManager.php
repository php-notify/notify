<?php

namespace Notify\Middleware;

use Notify\Envelope\Envelope;

final class MiddlewareManager
{
    /**
     * @var \Notify\Middleware\MiddlewareInterface[]
     */
    private $middlewareList;

    /**
     * @var callable
     */
    private $middlewareChain;

    /**
     * @param \Notify\Middleware\MiddlewareInterface[] $middlewareList
     */
    public function __construct(array $middlewareList = array())
    {
        $this->middlewareList  = $middlewareList;
        $this->middlewareChain = $this->createExecutionChain($middlewareList);
    }

    /**
     * @param \Notify\Envelope\Envelope[]|\Notify\Notification\NotificationInterface[] $envelopes
     *
     * @return array
     */
    public function handleMany($envelopes)
    {
        $that = $this;

        return array_map(
            static function ($envelope) use ($that) {
                return $that->handle($envelope);
            },
            $envelopes
        );
    }

    /**
     * Executes the given command and optionally returns a value
     *
     * @param \Notify\Envelope\Envelope|\Notify\Notification\NotificationInterface $envelope
     *
     * @return mixed
     */
    public function handle($envelope)
    {
        $envelope = Envelope::wrap($envelope);

        $middlewareChain = $this->middlewareChain;

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
        $this->middlewareList[] = $middleware;
        $this->middlewareChain  = $this->createExecutionChain($this->middlewareList);

        return $this;
    }

    /**
     * @param \Notify\Middleware\MiddlewareInterface[] $middlewareList
     *
     * @return callable
     */
    private function createExecutionChain(array $middlewareList)
    {
        $lastCallable = static function () {
            // the final callable is a no-op
        };

        while ($middleware = array_pop($middlewareList)) {
            $lastCallable = static function ($command) use ($middleware, $lastCallable) {
                return $middleware->handle($command, $lastCallable);
            };
        }

        return $lastCallable;
    }
}
