<?php

namespace Notify\Filter;

use Notify\Storage\StorageInterface;

class DefaultFilter implements FilterInterface
{
    private $filterBuilder;

    public function __construct(FilterBuilder $filterBuilder)
    {
        $this->filterBuilder = $filterBuilder;
    }

    public function filter($envelopes, $criteria = [])
    {
        return $this->filterBuilder->withCriteria($criteria)->filter($envelopes);
    }
}
