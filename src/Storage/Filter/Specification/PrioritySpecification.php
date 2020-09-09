<?php

namespace Yoeunes\Notify\Storage\Filter\Specification;

use Yoeunes\Notify\Envelope\Envelope;

final class PrioritySpecification implements SpecificationInterface
{
    /**
     * @var int
     */
    private $minPriority;

    /**
     * @var null|int
     */
    private $maxPriority;

    public function __construct($minPriority, $maxPriority = null)
    {
        $this->minPriority = $minPriority;
        $this->maxPriority = $maxPriority;
    }

    /**
     * @param \Yoeunes\Notify\Envelope\Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Yoeunes\Notify\Envelope\Stamp\PriorityStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxPriority && $stamp->getPriority() > $this->maxPriority) {
            return false;
        }

        return $stamp->getPriority() >= $this->minPriority;
    }
}
