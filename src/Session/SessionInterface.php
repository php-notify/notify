<?php

namespace Yoeunes\Notify\Session;

interface SessionInterface
{
    public function get($key, $default = null);

    public function flash($key, $value);
}
