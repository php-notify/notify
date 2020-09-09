<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Storage\Filter\FilterManager;

abstract class AbstractPresenter implements PresenterInterface
{
    protected $filter;
    protected $filterDriver = 'default';

    public function __construct(FilterManager $filter)
    {
        $this->filter = $filter;
    }

    protected function getEnvelopes()
    {
        return $this->filter->make($this->filterDriver)->getEnvelopes();
    }

    /**
     * @param string $filter
     *
     * @return self
     */
    public function filter($filter = 'default')
    {
        $this->filterDriver = $filter;

        return $this;
    }
}
