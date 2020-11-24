<?php

namespace Notify\Tests\Storage;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\LifeStamp;
use Notify\Notification\Notification;
use Notify\Storage\ArrayStorage;
use Notify\Tests\TestCase;

final class ArrayStorageTest extends TestCase
{
    public function testStorage()
    {
        $e1 = new Envelope(new Notification('success', 'success message'));
        $e2 = new Envelope(new Notification('success', 'success message'), new LifeStamp(2));
        $e3 = new Envelope(new Notification('success', 'success message'));
        $e4 = new Envelope(new Notification('success', 'success message'));

        $storage = new ArrayStorage();
        $storage->add($e1);
        $storage->add($e2);
        $storage->add($e3);
        $storage->add($e4);

        $this->assertCount(4, $storage->get());

        $storage->flush(array($e2, $e1));

        $this->assertCount(3, $storage->get());
        $this->assertSame(array($e2, $e3, $e4), $storage->get());
    }
}
