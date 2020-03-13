<?php

namespace Yoeunes\Notify\Producer;

use Yoeunes\Notify\Manager\AbstractManager;

final class ProducerManager extends AbstractManager
{
    protected function getConfigKeyForDefaultDriver()
    {
        return 'default_notifier';
    }

    protected function getConfigKeyForDriversList()
    {
        return 'notifiers';
    }

    protected function getFactoryFullyQualifiedName()
    {
        return '\Yoeunes\Notify\Producer\ProducerInterface';
    }
}
