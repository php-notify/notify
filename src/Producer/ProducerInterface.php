<?php

namespace Notify\Producer;

interface ProducerInterface
{
    /**
     * @param string               $type
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Notify\Notification\NotificationInterface
     */
    public function createNotification($type, $message, $title = '', $context = array());

    /**
     * @return \Notify\Renderer\RendererInterface
     */
    public function getRenderer();

    /**
     * @param string $type
     * @param string $message
     * @param string $title
     * @param array  $context
     *
     * @return \Notify\Envelope\Envelope
     */
    public function render($type, $message, $title = '', $context = array(), array $stamps = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Notify\Envelope\Envelope
     */
    public function error($message, $title = '', $context = array(), array $stamps = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Notify\Envelope\Envelope
     */
    public function info($message, $title = '', $context = array(), array $stamps = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Notify\Envelope\Envelope
     */
    public function success($message, $title = '', $context = array(), array $stamps = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Notify\Envelope\Envelope
     */
    public function warning($message, $title = '', $context = array(), array $stamps = array());
}
