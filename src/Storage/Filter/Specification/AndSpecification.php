<?php

namespace Notify\Storage\Filter\Specification;

use Notify\Envelope\Envelope;

final class AndSpecification implements SpecificationInterface
{
    /**
     * @var \Notify\Storage\Filter\Specification\SpecificationInterface[]
     */
    private $specifications;

    /**
     * @param array|mixed ...$specifications
     */
    public function __construct($specifications = array())
    {
        $specifications = is_array($specifications) ? $specifications : func_get_args();

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
}
