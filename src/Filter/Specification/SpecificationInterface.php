<?php

namespace Notify\Filter\Specification;

use Notify\Envelope\Envelope;

interface SpecificationInterface
{
    /**
     * @param \Notify\Envelope\Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope);
}
