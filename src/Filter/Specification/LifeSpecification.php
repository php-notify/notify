<?php

namespace Notify\Filter\Specification;

use Notify\Envelope\Envelope;

final class LifeSpecification implements SpecificationInterface
{
    /**
     * @var int
     */
    private $minLife;

    /**
     * @var int|null
     */
    private $maxLife;

    public function __construct($minLife, $maxLife = null)
    {
        $this->minLife = $minLife;
        $this->maxLife = $maxLife;
    }

    /**
     * @param \Notify\Envelope\Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Notify\Envelope\Stamp\LifeStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxLife && $stamp->getLife() > $this->maxLife) {
            return false;
        }

        return $stamp->getLife() >= $this->minLife;
    }
}
