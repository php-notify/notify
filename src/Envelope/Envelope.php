<?php

namespace Notify\Envelope;

use Notify\Envelope\Stamp\StampInterface;

final class Envelope
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
     * @param \Notify\Envelope\Envelope|\Notify\Notification\NotificationInterface $notification
     * @param \Notify\Envelope\Stamp\StampInterface[]                              $stamps
     */
    public function __construct($notification, $stamps = array())
    {
        $this->notification = $notification;
        $stamps             = is_array($stamps) ? $stamps : array_slice(func_get_args(), 1);
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
            $this->withStamp($stamp);
        }

        return $this;
    }

    /**
     * @param \Notify\Envelope\Stamp\StampInterface $stamp
     *
     * @return $this
     */
    public function withStamp(StampInterface $stamp)
    {
        $this->stamps[get_class($stamp)] = $stamp;

        return $this;
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
}
