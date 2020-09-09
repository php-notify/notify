<?php

namespace Yoeunes\Notify\Storage\Filter;

use Yoeunes\Notify\Config\ConfigInterface;
use Yoeunes\Notify\Manager\AbstractManager;

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
