<?php

namespace Notify\Renderer;

use Notify\Config\ConfigInterface;
use Notify\Manager\AbstractManager;

/**
 * @method \Notify\Renderer\RendererInterface make($driver = null)
 */
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
