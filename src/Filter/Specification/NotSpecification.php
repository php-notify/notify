<?php

namespace Notify\Filter\Specification;

use Notify\Envelope\Envelope;

final class NotSpecification implements SpecificationInterface
{
    /**
     * @var \Notify\Filter\Specification\SpecificationInterface
     */
    private $specification;

    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        return !$this->specification->isSatisfiedBy($envelope);
    }
}
