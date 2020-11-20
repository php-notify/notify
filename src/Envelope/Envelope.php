<?php

namespace Notify\Envelope;

use Notify\Notification\NotificationInterface;

final class Envelope implements NotificationInterface
{
    /**
     * @var \Notify\Notification\NotificationInterface
     */
    private $notification;

    /**
     * @var \Notify\Envelope\Stamp\StampInterface[]
     */
    private $stamps = array();

    /**
     * @param \Notify\Notification\NotificationInterface $notification
     * @param \Notify\Envelope\Stamp\StampInterface[]    $stamps
     */
    public function __construct(NotificationInterface $notification, array $stamps = array())
    {
        $this->notification = $notification;
        call_user_func_array(array($this, 'with'), $stamps);
    }

    /**
     * @param array|\Notify\Envelope\Stamp\StampInterface $stamps
     *
     * @return Envelope a new Envelope instance with additional stamp
     */
    public function with($stamps = array())
    {
        $stamps = is_array($stamps) ? $stamps : func_get_args();

        foreach ($stamps as $stamp) {
            $this->stamps[get_class($stamp)] = $stamp;
        }

        return $this;
    }

    /**
     * @param string $stampFqcn
     *
     * @return \Notify\Envelope\Stamp\StampInterface|null
     */
    public function get($stampFqcn)
    {
        if (!isset($this->stamps[$stampFqcn])) {
            return null;
        }

        return $this->stamps[$stampFqcn];
    }

    /**
     * All stamps by their class name
     *
     * @return \Notify\Envelope\Stamp\StampInterface[]
     */
    public function all()
    {
        return $this->stamps;
    }

    /**
     * The original notification contained in the envelope
     *
     * @return \Notify\Notification\NotificationInterface
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->notification->getType();
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        return $this->notification->getMessage();
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->notification->getTitle();
    }

    /**
     * @inheritDoc
     */
    public function getContext()
    {
        return $this->notification->getContext();
    }

    /**
     * Makes sure the notification is in an Envelope and adds the given stamps.
     *
     * @param \Notify\Notification\NotificationInterface|\Notify\Envelope\Envelope $notification
     * @param \Notify\Envelope\Stamp\StampInterface[]                              $stamps
     *
     * @return \Notify\Envelope\Envelope
     */
    public static function wrap($notification, array $stamps = array())
    {
        $envelope = $notification instanceof self ? $notification : new self($notification);

        return call_user_func_array(array($envelope, 'with'), $stamps);
    }
}
