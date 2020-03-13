<?php

namespace Yoeunes\Notify\Producer;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\ProducerStamp;
use Yoeunes\Notify\Notification\Notification;

abstract class AbstractProducer implements ProducerInterface
{
    /**
     * @var array<string, mixed>
     */
    protected $config;

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
        $envelope->with(new ProducerStamp($this->getConfig('driver')));

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
