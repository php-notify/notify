<?php

namespace Yoeunes\Notify\Producer;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\RendererStamp;
use Yoeunes\Notify\Middleware\MiddlewareManager;
use Yoeunes\Notify\Notification\Notification;
use Yoeunes\Notify\Storage\StorageInterface;

abstract class AbstractProducer implements ProducerInterface
{
    private $storage;
    private $middleware;

    public function __construct(StorageInterface $storage, MiddlewareManager $middleware)
    {
        $this->storage = $storage;
        $this->middleware = $middleware;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getRenderer();

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
        $envelope->with(new RendererStamp($this->getRenderer()));

        $this->middleware->handle($envelope);
        $this->storage->add($envelope);

        return $this;
    }
}
