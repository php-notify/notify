<?php

namespace Notify\Storage;

use Notify\Config\ConfigInterface;
use Notify\Manager\AbstractManager;

final class StorageManager extends AbstractManager
{
    /**
     * @var \Notify\Config\ConfigInterface
     */
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    protected function getDefaultDriver()
    {
        return $this->config->get('storage');
    }
}
