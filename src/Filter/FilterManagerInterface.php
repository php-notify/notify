<?php

namespace Yoeunes\Notify\Filter;

use Yoeunes\Notify\Filter\Specification\SpecificationInterface;

interface FilterManagerInterface
{
    /**
     * @param \Yoeunes\Notify\Notification\NotificationInterface[]|\Yoeunes\Notify\Envelope\Envelope[]        $notifications
     * @param \Yoeunes\Notify\Filter\Specification\SpecificationInterface $specification
     *
     * @return \Yoeunes\Notify\Notification\NotificationInterface[]
     */
    public function filter(array $notifications, SpecificationInterface $specification);
}
