<?php

namespace Yoeunes\Notify\Factories;

interface NotificationFactoryInterface
{
    /**
     * @param string               $type
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notifiers\NotificationInterface
     */
    public function notification($type, $message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notifiers\NotificationInterface
     */
    public function error($message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notifiers\NotificationInterface
     */
    public function info($message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notifiers\NotificationInterface
     */
    public function success($message, $title = '', $context = array());

    /**
     * @param string               $message
     * @param string               $title
     * @param array<string, mixed> $context
     *
     * @return \Yoeunes\Notify\Notifiers\NotificationInterface
     */
    public function warning($message, $title = '', $context = array());

    /**
     * @return bool
     */
    public function readyToRender();

    /**
     * @return string
     */
    public function render();

    /**
     * @param array<string, mixed> $config
     *
     * @return void
     */
    public function setConfig($config);
}
