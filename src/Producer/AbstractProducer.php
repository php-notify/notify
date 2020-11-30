<?php

namespace Notify\Producer;

use Notify\Notification\Notification;
use Notify\Notification\NotificationBuilder;

/**
 * @method \Notify\Notification\NotificationBuilderInterface type($type, $message = null, array $options = array())
 * @method \Notify\Notification\NotificationBuilderInterface message($message)
 * @method \Notify\Notification\NotificationBuilderInterface options($options)
 * @method \Notify\Notification\NotificationBuilderInterface setOption($name, $value)
 * @method \Notify\Notification\NotificationBuilderInterface unsetOption($name)
 * @method \Notify\Notification\NotificationBuilderInterface success($message = null, array $options = array())
 * @method \Notify\Notification\NotificationBuilderInterface error($message = null, array $options = array())
 * @method \Notify\Notification\NotificationBuilderInterface info($message = null, array $options = array())
 * @method \Notify\Notification\NotificationBuilderInterface warning($message = null, array $options = array())
 * @method \Notify\Notification\NotificationInterface getNotification()
 */
abstract class AbstractProducer implements ProducerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNotificationBuilder()
    {
        return new NotificationBuilder($this->createNotification());
    }

    /**
     * {@inheritdoc}
     */
    public function createNotification()
    {
        return new Notification();
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return get_class($this) === $name;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array(array($this->createNotificationBuilder(), $method), $parameters);
    }
}
