<?php

namespace Yoeunes\Notify\Middleware;

use Yoeunes\Notify\Envelope\Envelope;

final class StackMiddleware implements MiddlewareInterface, StackInterface
{
    private $stack;

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function handle(Envelope $envelope, StackInterface $stack)
    {
        return $envelope;
    }

    /**
     * @inheritDoc
     */
    public function next()
    {

    }
}
