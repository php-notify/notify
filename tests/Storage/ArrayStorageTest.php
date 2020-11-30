<?php

namespace Notify\Tests\Storage;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\UuidStamp;
use Notify\Notification\Notification;
use Notify\Storage\ArrayStorage;
use Notify\Tests\TestCase;

final class ArrayStorageTest extends TestCase
{
    public function testAdd()
    {
        $storage = new ArrayStorage();
        $envelopes = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification('success', 'success message'));
            $storage->add($envelopes[$index]);
        }

        $this->assertCount(5, $storage->all());
    }

    public function testAddNotificationWithUuidStamp()
    {
        $storage = new ArrayStorage();
        $storage->add(new Envelope(new Notification('success')));

        $envelopes = $storage->all();

        $this->assertCount(1, $envelopes);

        $uuid = $envelopes[0]->get('Notify\Envelope\Stamp\UuidStamp');
        $this->assertNotNull($uuid);
    }

    public function testClear()
    {
        $storage = new ArrayStorage();
        $envelopes = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification('success', 'success message'));
            $storage->add($envelopes[$index]);
        }

        $storage->clear();

        $this->assertSame(array(), $storage->all());
    }

    public function testRemove()
    {
        $storage = new ArrayStorage();
        $envelopes = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification('success', 'success message'), new UuidStamp());
            $storage->add($envelopes[$index]);
        }

        $storage->remove($envelopes[0], $envelopes[2]);

        $actual = UuidStamp::indexWithUuid($storage->all());
        $expected = UuidStamp::indexWithUuid($envelopes[1], $envelopes[3], $envelopes[4]);

        $this->assertSame(array(), array_diff_key($actual, $expected));
    }
}
