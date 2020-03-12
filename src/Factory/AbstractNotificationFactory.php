<?php

namespace Yoeunes\Notify\Factory;

abstract class AbstractNotificationFactory implements NotificationFactoryInterface
{
    /**
     * @var array<string, mixed>
     */
    protected $config;

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
    public function error($message, $title = '', $context = array())
    {
        return $this->createNotification('error', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, $title = '', $context = array())
    {
        return $this->createNotification('info', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function success($message, $title = '', $context = array())
    {
        return $this->createNotification('success', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, $title = '', $context = array())
    {
        return $this->createNotification('warning', $message, $title, $context);
    }
}
