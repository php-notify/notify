<?php

namespace Yoeunes\Notify\Notification;

interface NotificationInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return array<string, mixed>
     */
    public function getContext();

    /**
     * @return string
     */
    public function render();
}
