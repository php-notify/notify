<?php

namespace Yoeunes\Notify\Filter;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Filter\Specification\SpecificationInterface;
use Yoeunes\Notify\Middleware\MiddlewareStack;

final class FilterManager implements FilterManagerInterface
{
    /**
     * @var \Yoeunes\Notify\Middleware\MiddlewareStack
     */
    private $middleware;

    public function __construct(MiddlewareStack $middleware)
    {
        $this->middleware = $middleware;
    }

    /**
     * @inheritDoc
     */
    public function filter(array $notifications, SpecificationInterface $specification)
    {
        $envelopes = array_filter(
            $this->middleware->handleMany($notifications),
            function (Envelope $envelope) use ($specification) {
                return $specification->isSatisfiedBy($envelope);
            }
        );

        return array_values(array_map(function (Envelope $envelope) {
            return $envelope->getNotification();
        }, $envelopes));
    }
}
