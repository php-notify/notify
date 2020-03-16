<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Presenter\Cli\CliAdapter;
use Yoeunes\Notify\Presenter\Cli\LinuxAdapter;
use Yoeunes\Notify\Storage\StorageInterface;

final class CliPresenter implements PresenterInterface
{
    private $storage;
    private $adapter;

    public function __construct(StorageInterface $storage, CliAdapter $adapter = null)
    {
        $this->storage = $storage;
        $this->adapter = $adapter ?: new LinuxAdapter();
    }

    /**
     * @inheritDoc
     */
    public function support(array $context)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return $this->adapter->render($this->storage->get());
    }
}
