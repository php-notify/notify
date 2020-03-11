<?php

namespace Yoeunes\Notify\Filter\Specification;

use Yoeunes\Notify\Envelope\Envelope;

final class AndSpecification implements SpecificationInterface
{
    /**
     * @var \Yoeunes\Notify\Filter\FilterManagerInterface[]
     */
    private $specifications;

    /**
     * @param \Yoeunes\Notify\Filter\Specification\SpecificationInterface[] $specifications
     */
    public function __construct(array $specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($envelope)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param \Yoeunes\Notify\Filter\Specification\SpecificationInterface $specification
     *
     * @return $this
     */
    public function addSpecification(SpecificationInterface $specification)
    {
        if (!in_array($specification, $this->specifications)) {
            $this->specifications = $specification;
        }

        return $this;
    }
}
