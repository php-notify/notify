<?php

namespace Yoeunes\Notify\Factories;

interface NotifierFactoryInterface
{
    public function __invoke($config);

    public function notification($type, $message, $title = '', $options = []);

    public function error($message, $title = '', $options = []);

    public function info($message, $title = '', $options = []);

    public function success($message, $title = '', $options = []);

    public function warning($message, $title = '', $options = []);

    public function readyToRender();

    public function render();
}
