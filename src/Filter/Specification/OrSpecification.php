<?php

namespace Yoeunes\Notify\Filter\Specification;

use Yoeunes\Notify\Envelope\Envelope;

final class OrSpecification implements SpecificationInterface
{
    /**
     * @var \Yoeunes\Notify\Filter\Specification\SpecificationInterface[]
     */
    private $specifications;

    public function __construct()
    {
        $this->specifications = func_get_args();
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($envelope)) {
                return true;
            }
        }

        return false;
    }
}
