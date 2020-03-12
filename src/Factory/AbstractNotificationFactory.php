<?php

namespace Yoeunes\Notify\Factory;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\FingerprintStamp;
use Yoeunes\Notify\Notification\Notification;
use Yoeunes\Notify\Storage\StorageManagerInterface;

abstract class AbstractNotificationFactory implements NotificationFactoryInterface
{
    /**
     * @var \Yoeunes\Notify\Storage\StorageManagerInterface
     */
    protected $storageManager;

    /**
     * @var array<string, mixed>
     */
    protected $config;

    public function __construct(StorageManagerInterface $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function createRenderer();

    /**
     * {@inheritdoc}
     */
    public function createNotification($type, $message, $title = '', $context = array())
    {
        return new Notification($type, $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, $title = '', $context = array())
    {
        return $this->render('error', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, $title = '', $context = array())
    {
        return $this->render('info', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function success($message, $title = '', $context = array())
    {
        return $this->render('success', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, $title = '', $context = array())
    {
        return $this->render('warning', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function render($type, $message, $title = '', $context = array())
    {
        $envelope = Envelope::wrap($this->createNotification($type, $message, $title, $context));
        $envelope->with(new FingerprintStamp(spl_object_hash($this)));

        $this->storageManager->addNotification($envelope);

        return $envelope;
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
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function getStorageManager()
    {
        return $this->storageManager;
    }
}
