<?php

namespace Yoeunes\Notify\Factories;

interface NotifierFactoryInterface
{
    public function notification($type, $message, $title = '', $options = array());

    public function error($message, $title = '', $options = array());

    public function info($message, $title = '', $options = array());

    public function success($message, $title = '', $options = array());

    public function warning($message, $title = '', $options = array());

    public function readyToRender();

    public function render();

    public function setConfig($config);
}
