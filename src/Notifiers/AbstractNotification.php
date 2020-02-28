<?php

namespace Yoeunes\Notify\Notifiers;

abstract class AbstractNotification implements NotificationInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var array<string, mixed>
     */
    protected $context;

    /**
     * BaseNotification constructor.
     *
     * @param string $type
     * @param string $message
     * @param string $title
     * @param array<string, mixed> $context
     */
    public function __construct($type, $message, $title, $context)
    {
        $this->type = $type;
        $this->message = $message;
        $this->title = $title;
        $this->context = $context;
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function getContext()
    {
        return $this->context;
    }
}
