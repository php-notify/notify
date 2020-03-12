<?php

namespace Yoeunes\Notify\Storage;

final class StorageManager implements StorageManagerInterface
{
    /**
     * @var \Yoeunes\Notify\Storage\StoreInterface
     */
    private $store;

    private $notifications = array();

    private $scripts = array();

    private $styles = array();

    private $fingerprints = array();

    public function __construct(StoreInterface $store)
    {
        $this->store = $store;
    }
}
