<?php

namespace Yoeunes\Notify\Factories\Behaviours;

use Yoeunes\Notify\Notifiers\NotificationInterface;

trait SingleNotificationAwareTrait
{
    abstract public function getNotification();

    public function readyToRender()
    {
        return $this->getNotification() instanceof NotificationInterface;
    }
}
