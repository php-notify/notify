<?php

namespace Yoeunes\Notify\Factory;

abstract class AbstractNotificationFactory implements NotificationFactoryInterface
{
    /**
     * @var array<string, mixed>
     */
    protected $config;

    /**
     * @inheritDoc
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function error($message, $title = '', $context = array())
    {
        return $this->notification('error', $message, $title, $context);
    }

    /**
     * @inheritDoc
     */
    public function info($message, $title = '', $context = array())
    {
        return $this->notification('info', $message, $title, $context);
    }

    /**
     * @inheritDoc
     */
    public function success($message, $title = '', $context = array())
    {
        return $this->notification('success', $message, $title, $context);
    }

    /**
     * @inheritDoc
     */
    public function warning($message, $title = '', $context = array())
    {
        return $this->notification('warning', $message, $title, $context);
    }
}
