<?php

namespace Yoeunes\Notify\Producer;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Envelope\Stamp\RendererStamp;
use Yoeunes\Notify\Envelope\Stamp\StampInterface;
use Yoeunes\Notify\Middleware\MiddlewareManager;
use Yoeunes\Notify\Notification\Notification;
use Yoeunes\Notify\Notification\NotificationInterface;
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
    public function error($message, $title = '', $context = array(), array $stamps = [])
    {
        return $this->render('error', $message, $title, $context, $stamps);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, $title = '', $context = array(), array $stamps = [])
    {
        return $this->render('info', $message, $title, $context, $stamps);
    }

    /**
     * {@inheritdoc}
     */
    public function success($message, $title = '', $context = array(), array $stamps = [])
    {
        return $this->render('success', $message, $title, $context, $stamps);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, $title = '', $context = array(), array $stamps = [])
    {
        return $this->render('warning', $message, $title, $context, $stamps);
    }

    /**
     * {@inheritdoc}
     */
    public function render($type, $message, $title = '', $context = array(), array $stamps = [])
    {
        if (is_array($title) || $title instanceof StampInterface) {
            $stamps = (array) $title;
            $title = '';
        }

        $notification = $this->createNotification($type, $message, $title, $context);

        return $this->dispatch($notification, $stamps);
    }

    /**
     * @param NotificationInterface|\Yoeunes\Notify\Envelope\Envelope $notification
     * @param array $stamps
     */
    public function dispatch($notification, array $stamps = [])
    {
        $stamps[] = new RendererStamp($this->getRenderer());

        $envelope = Envelope::wrap($notification);
        $envelope->with($stamps);

        $this->middleware->handle($envelope);
        $this->storage->add($envelope);

        return $envelope;
    }
}
