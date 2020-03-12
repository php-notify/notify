<?php

namespace Yoeunes\Notify\Factory;

interface NotificationFactoryInterface
{
    /**
     * @param string               $type
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notification\NotificationInterface
     */
    public function notification($type, $message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notification\NotificationInterface
     */
    public function error($message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notification\NotificationInterface
     */
    public function info($message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notification\NotificationInterface
     */
    public function success($message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notification\NotificationInterface
     */
    public function warning($message, $title = '', $context = array());

    /**
     * @param array<string, mixed> $config
     */
    public function setConfig($config);
}
