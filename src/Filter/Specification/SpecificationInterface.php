<?php

namespace Yoeunes\Notify\Filter\Specification;

use Yoeunes\Notify\Envelope\Envelope;

interface SpecificationInterface
{
    /**
     * @param \Yoeunes\Notify\Envelope\Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope);
}
