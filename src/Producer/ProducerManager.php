<?php

namespace Notify\Producer;

use Notify\Config\ConfigInterface;
use Notify\Manager\AbstractManager;

/**
 * @method \Notify\Producer\ProducerInterface make($driver = null)
 */
final class ProducerManager extends AbstractManager
{
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function getDefaultDriver()
    {
        return $this->config->get('default');
    }
}
