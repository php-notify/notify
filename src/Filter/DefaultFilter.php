<?php

namespace Notify\Filter;

class DefaultFilter implements FilterInterface
{
    private $filterBuilder;

    public function __construct(FilterBuilder $filterBuilder)
    {
        $this->filterBuilder = $filterBuilder;
    }

    public function filter($envelopes, $criteria = array())
    {
        return $this->filterBuilder->withCriteria($criteria)->filter($envelopes);
    }
}
