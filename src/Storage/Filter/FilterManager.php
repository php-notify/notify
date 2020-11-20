<?php

namespace Notify\Storage\Filter;

use Notify\Config\ConfigInterface;
use Notify\Manager\AbstractManager;

final class FilterManager extends AbstractManager
{
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    protected function getDefaultDriver()
    {
        return $this->config->get('default_filter');
    }
}
