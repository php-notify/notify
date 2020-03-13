<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Manager\AbstractManager;

final class PresenterManager extends AbstractManager
{
    protected function getConfigKeyForDefaultDriver()
    {
        return 'default_presenter';
    }

    protected function getConfigKeyForDriversList()
    {
        return 'presenters';
    }

    protected function getFactoryFullyQualifiedName()
    {
        return '\Yoeunes\Notify\Presenter\PresenterInterface';
    }
}
