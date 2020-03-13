<?php

namespace Yoeunes\Notify\Producer;

interface ProducerInterface
{
    /**
     * @param string               $type
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notification\NotificationInterface
     */
    public function createNotification($type, $message, $title = '', $context = array());

    /**
     * @return \Yoeunes\Notify\Renderer\RendererInterface
     */
    public function createRenderer();

    /**
     * @param        $type
     * @param        $message
     * @param string $title
     * @param array  $context
     *
     * @return \Yoeunes\Notify\Envelope\Envelope
     */
    public function render($type, $message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Envelope\Envelope
     */
    public function error($message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Envelope\Envelope
     */
    public function info($message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Envelope\Envelope
     */
    public function success($message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Envelope\Envelope
     */
    public function warning($message, $title = '', $context = array());

    /**
     * @param array<string, mixed> $config
     */
    public function setConfig($config);
}
