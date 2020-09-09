<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Presenter\Cli\CliAdapter;
use Yoeunes\Notify\Presenter\Cli\LinuxAdapter;
use Yoeunes\Notify\Storage\Filter\FilterManager;

final class CliPresenter extends AbstractPresenter
{
    private $adapter;

    public function __construct(FilterManager $filter, CliAdapter $adapter = null)
    {
        parent::__construct($filter);

        $this->adapter = $adapter ?: new LinuxAdapter();
    }

    /**
     * @inheritDoc
     */
    public function support(array $context)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->adapter->render($this->getEnvelopes());
    }
}
