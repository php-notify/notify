<?php

namespace Yoeunes\Notify\Notifiers;

abstract class BaseNotification implements NotificationInterface
{
    private $type;
    private $message;
    private $title;
    private $context;

    public function __construct($type, $message, $title, $options)
    {
        $this->type = $type;
        $this->message = $message;
        $this->title = $title;
        $this->context = $options;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContext()
    {
        return $this->context;
    }
}
