<?php

namespace Yoeunes\Notify\Notifiers;

interface NotificationInterface
{
    public function getType();

    public function getMessage();

    public function getTitle();

    public function getContext();

    public function getNotifier();

    public function render();
}
