<?php

namespace Yoeunes\Notify\Config;

interface ConfigInterface
{
    public function get($key, $default = null);
}
