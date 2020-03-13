<?php

namespace Yoeunes\Notify\Presenter;

interface PresenterInterface
{
    public function render();

    /**
     * @param array<string, mixed> $config
     */
    public function setConfig($config);
}
