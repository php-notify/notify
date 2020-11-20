<?php

namespace Notify\Notification;

final class Notification implements NotificationInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $title;

    /**
     * @var array<string, mixed>
     */
    private $context;

    /**
     * @param string               $type
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     */
    public function __construct($type, $message, $title = '', $context = array())
    {
        $this->type    = $type;
        $this->message = $message;
        $this->title   = $title;
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->context;
    }
}
