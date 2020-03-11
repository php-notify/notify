<?php

namespace Yoeunes\Notify\Filter\Specification;

use Yoeunes\Notify\Envelope\Envelope;

final class TimeSpecification implements SpecificationInterface
{
    /**
     * @var int
     */
    private $minTime;

    /**
     * @var null|int
     */
    private $maxTime;

    public function __construct($minTime, $maxTime = null)
    {
        $this->minTime = $minTime;
        $this->maxTime = $maxTime;
    }

    /**
     * @param \Yoeunes\Notify\Envelope\Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Yoeunes\Notify\Envelope\Stamp\TimeStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxTime && $stamp->getCreatedAt() > $this->maxTime) {
            return false;
        }

        return $stamp->getCreatedAt() >= $this->minTime;
    }
}
