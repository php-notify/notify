<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Storage\StorageManager;

abstract class AbstractPresenter implements PresenterInterface
{
    /**
     * @var \Yoeunes\Notify\Storage\StorageManager
     */
    protected $storageManager;

    /**
     * @var array<string, mixed>
     */
    protected $config;

    public function __construct(StorageManager $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($key = null)
    {
        if (null === $key) {
            return $this->config;
        }

        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        return null;
    }
}
