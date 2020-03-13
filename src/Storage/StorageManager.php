<?php

namespace Yoeunes\Notify\Storage;

use Yoeunes\Notify\Manager\AbstractManager;

final class StorageManager extends AbstractManager
{
    /**
     * @var \Yoeunes\Notify\Storage\StoreInterface
     */
    private $store;

    private $notifications = array();

    private $scripts = array();

    private $styles = array();

    private $fingerprints = array();
}
