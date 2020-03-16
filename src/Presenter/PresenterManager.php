<?php

namespace Yoeunes\Notify\Presenter;

use Yoeunes\Notify\Config\ConfigInterface;
use Yoeunes\Notify\Manager\AbstractManager;

final class PresenterManager extends AbstractManager
{
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    protected function getDefaultDriver()
    {
        return $this->config->get('presenter');
    }

    public function getPresenterFromContext(array $context)
    {
        foreach ($this->drivers as $presenter) {
            if ($presenter->support($context)) {
                return $presenter;
            }
        }

        throw new \InvalidArgumentException(sprintf("No presenter found for the given context"));
    }
}
