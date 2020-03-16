<?php

namespace Yoeunes\Notify\Storage;

use Yoeunes\Notify\Config\ConfigInterface;
use Yoeunes\Notify\Manager\AbstractManager;

final class StorageManager extends AbstractManager
{
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
