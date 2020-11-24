<?php

namespace Notify\Tests\Notification;

use Notify\Notification\Notification;
use Notify\Tests\TestCase;

final class NotificationTest extends TestCase
{
    public function testNotification()
    {
        $notification = new Notification('type', 'message', 'title', array('context'));

        $this->assertSame('type', $notification->getType());
        $this->assertSame('message', $notification->getMessage());
        $this->assertSame('title', $notification->getTitle());
        $this->assertSame(array('context'), $notification->getContext());
    }
}
