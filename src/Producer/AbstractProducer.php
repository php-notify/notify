<?php

namespace Notify\Producer;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\RendererStamp;
use Notify\Envelope\Stamp\StampInterface;
use Notify\Middleware\MiddlewareManager;
use Notify\Notification\Notification;
use Notify\Notification\NotificationInterface;
use Notify\Storage\StorageInterface;

abstract class AbstractProducer implements ProducerInterface
{
    private $storage;

    private $middleware;

    public function __construct(StorageInterface $storage, MiddlewareManager $middleware)
    {
        $this->storage    = $storage;
        $this->middleware = $middleware;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getRenderer();

    /**
     * {@inheritdoc}
     */
    public function error($message, $title = '', $context = array(), array $stamps = array())
    {
        return $this->render('error', $message, $title, $context, $stamps);
    }

    /**
     * {@inheritdoc}
     */
    public function render($type, $message, $title = '', $context = array(), array $stamps = array())
    {
        if (is_array($title) || $title instanceof StampInterface) {
            $stamps = (array)$title;
            $title  = '';
        }

        $notification = $this->createNotification($type, $message, $title, $context);

        return $this->dispatch($notification, $stamps);
    }

    /**
     * {@inheritdoc}
     */
    public function createNotification($type, $message, $title = '', $context = array())
    {
        return new Notification($type, $message, $title, $context);
    }

    /**
     * @param NotificationInterface|\Notify\Envelope\Envelope $notification
     * @param array                                           $stamps
     *
     * @return Envelope
     */
    public function dispatch($notification, array $stamps = array())
    {
        $stamps[] = new RendererStamp($this->getRenderer());

        $envelope = Envelope::wrap($notification);
        $envelope->with($stamps);

        $this->middleware->handle($envelope);
        $this->storage->add($envelope);

        return $envelope;
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, $title = '', $context = array(), array $stamps = array())
    {
        return $this->render('info', $message, $title, $context, $stamps);
    }

    /**
     * {@inheritdoc}
     */
    public function success($message, $title = '', $context = array(), array $stamps = array())
    {
        return $this->render('success', $message, $title, $context, $stamps);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, $title = '', $context = array(), array $stamps = array())
    {
        return $this->render('warning', $message, $title, $context, $stamps);
    }
}
