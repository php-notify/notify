<?php

namespace Notify\Producer;

use Notify\Manager\AbstractManager;

/**
 * @method \Notify\Producer\ProducerInterface make($name = null, array $context = array())
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
final class ProducerManager extends AbstractManager
{
    public function getDefaultDriver()
    {
        return $this->config->get('default');
    }
}
