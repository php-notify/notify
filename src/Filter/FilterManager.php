<?php

namespace Notify\Filter;

use Notify\Config\ConfigInterface;
use Notify\Manager\AbstractManager;

/**
 * @method \Notify\Filter\FilterInterface make($driver = null)
 */
final class FilterManager extends AbstractManager
{
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    protected function getDefaultDriver()
    {
        return $this->config->get('default_filter', 'default');
    }
}
