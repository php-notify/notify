<?php

namespace Yoeunes\Notify\Factories\Behaviours;

trait MultipleNotificationAwareTrait
{
    abstract public function getNotifications();

    public function readyToRender()
    {
        return count($this->getNotifications()) > 0;
    }

    private function notificationsToString()
    {
        $html = '';

        foreach ($this->getNotifications() as $notification) {
            $html .= $notification->render() . PHP_EOL;
        }

        return $html;
    }
}
