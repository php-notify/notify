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
        return $this->notification('error', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, $title = '', $context = array())
    {
        return $this->notification('info', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function success($message, $title = '', $context = array())
    {
        return $this->notification('success', $message, $title, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, $title = '', $context = array())
    {
        return $this->notification('warning', $message, $title, $context);
    }
}
