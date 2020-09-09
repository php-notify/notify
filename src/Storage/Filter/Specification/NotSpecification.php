<?php

namespace Yoeunes\Notify\Storage\Filter\Specification;

use Yoeunes\Notify\Envelope\Envelope;

final class NotSpecification implements SpecificationInterface
{
    /**
     * @var \Yoeunes\Notify\Storage\Filter\Specification\SpecificationInterface
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
