<?php

namespace Yoeunes\Notify\Envelope;

use Yoeunes\Notify\Notification\NotificationInterface;

final class Envelope
{
    /**
     * @var \Yoeunes\Notify\Notification\NotificationInterface
     */
    private $notification;

    /**
     * @var \Yoeunes\Notify\Envelope\Stamp\StampInterface[][]
     */
    private $stamps = array();

    /**
     * Envelope constructor.
     *
     * @param  \Yoeunes\Notify\Notification\NotificationInterface  $notification
     * @param  \Yoeunes\Notify\Envelope\Stamp\StampInterface[]     $stamps
     */
    public function __construct(NotificationInterface $notification, array $stamps = array())
    {
        $this->notification = $notification;
        foreach ($stamps as $stamp) {
            $this->stamps[get_class($stamp)][] = $stamp;
        }
    }

    /**
     * Makes sure the notification is in an Envelope and adds the given stamps.
     *
     * @param  NotificationInterface|\Yoeunes\Notify\Envelope\Envelope  $notification
     * @param  \Yoeunes\Notify\Envelope\Stamp\StampInterface[][]        $stamps
     *
     * @return \Yoeunes\Notify\Envelope\Envelope
     */
    public static function wrap($notification, array $stamps = array())
    {
        $envelope = $notification instanceof self ? $notification : new self($notification);

        return $envelope->with($stamps);
    }

    /**
     * @param  \Yoeunes\Notify\Envelope\Stamp\StampInterface[]  $stamps
     *
     * @return Envelope a new Envelope instance with additional stamp
     */
    public function with(array $stamps = array())
    {
        $cloned = clone $this;

        foreach ($stamps as $stamp) {
            $cloned->stamps[get_class($stamp)][] = $stamp;
        }

        return $cloned;
    }

    /**
     * @param  string  $stampFqcn
     *
     * @return \Yoeunes\Notify\Envelope\Stamp\StampInterface|null
     */
    public function last($stampFqcn)
    {
        return isset($this->stamps[$stampFqcn]) ? end($this->stamps[$stampFqcn]) : null;
    }

    /**
     * @param  string|null  $stampFqcn
     *
     * @return \Yoeunes\Notify\Envelope\Stamp\StampInterface[]|\Yoeunes\Notify\Envelope\Stamp\StampInterface[][] The
     *                                                                                                           stamps
     *                                                                                                           for
     *                                                                                                           the
     *                                                                                                           specified
     *                                                                                                           FQCN,
     *                                                                                                           or all
     *                                                                                                           stamps
     *                                                                                                           by
     *                                                                                                           their
     *                                                                                                           class
     *                                                                                                           name
     */
    public function all($stampFqcn = null)
    {
        if (null !== $stampFqcn) {
            return isset($this->stamps[$stampFqcn]) ? $this->stamps[$stampFqcn] : array();
        }

        return $this->stamps;
    }

    /**
     * @return \Yoeunes\Notify\Notification\NotificationInterface
     */
    public function getNotification()
    {
        return $this->notification;
    }
}
