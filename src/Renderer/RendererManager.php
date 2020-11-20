<?php

namespace Notify\Renderer;

use Notify\Config\ConfigInterface;
use Notify\Manager\AbstractManager;

class RendererManager extends AbstractManager
{
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    protected function getDefaultDriver()
    {
        return $this->config->get('renderer');
    }
}
