<?php

namespace Notify\Producer;

interface ProducerInterface
{
    /**
     * @return \Notify\Notification\NotificationInterface
     */
    public function createNotification();

    /**
     * @return \Notify\Notification\NotificationBuilderInterface
     */
    public function createNotificationBuilder();

    /**
     * @param string|null $name
     * @param array       $context
     *
     * @return boolean
     */
    public function supports($name = null, array $context = array());
}
