<?php

namespace Yoeunes\Notify\Storage;

interface StoreInterface
{
    /**
     * Returns an attribute.
     *
     * @param string $key
     * @param mixed  $default The default value if not found
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     *  Flash a key / value pair to the storage.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function flash($key, $value);
}
