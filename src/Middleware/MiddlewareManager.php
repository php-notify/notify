<?php

namespace Yoeunes\Notify\Middleware;

use Yoeunes\Notify\Envelope\Envelope;

final class MiddlewareManager
{
    /**
     * @var \Yoeunes\Notify\Middleware\MiddlewareInterface[]
     */
    private $middlewareList;

    /**
     * @var callable
     */
    private $middlewareChain;

    /**
     * @param \Yoeunes\Notify\Middleware\MiddlewareInterface[] $middlewareList
     */
    public function __construct(array $middlewareList = array())
    {
        $this->middlewareList = $middlewareList;
        $this->middlewareChain = $this->createExecutionChain($middlewareList);
    }

    /**
     * Executes the given command and optionally returns a value
     *
     * @param \Yoeunes\Notify\Envelope\Envelope|\Yoeunes\Notify\Notification\NotificationInterface $envelope
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
     * @param \Yoeunes\Notify\Envelope\Envelope[]|\Yoeunes\Notify\Notification\NotificationInterface[] $envelopes
     *
     * @return array
     */
    public function handleMany($envelopes)
    {
        $that = $this;
        return array_map(function ($envelope) use ($that) {
            return $that->handle($envelope);
        }, $envelopes);
    }

    /**
     * @param \Yoeunes\Notify\Middleware\MiddlewareInterface $middleware
     *
     * @return $this
     */
    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewareList[] = $middleware;
        $this->middlewareChain = $this->createExecutionChain($this->middlewareList);

        return $this;
    }

    /**
     * @param \Yoeunes\Notify\Middleware\MiddlewareInterface[] $middlewareList
     *
     * @return callable
     */
    private function createExecutionChain(array $middlewareList)
    {
        $lastCallable = static function () {
            // the final callable is a no-op
        };

        while ($middleware = \array_pop($middlewareList)) {
            $lastCallable = static function ($command) use ($middleware, $lastCallable) {
                return $middleware->handle($command, $lastCallable);
            };
        }

        return $lastCallable;
    }
}
