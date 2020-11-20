<?php

namespace Notify\Presenter;

use InvalidArgumentException;
use Notify\Config\ConfigInterface;
use Notify\Manager\AbstractManager;

final class PresenterManager extends AbstractManager
{
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function getPresenterFromContext(array $context)
    {
        foreach ($this->drivers as $presenter) {
            if ($presenter->support($context)) {
                return $presenter;
            }
        }

        throw new InvalidArgumentException(sprintf('No presenter found for the given context'));
    }

    protected function getDefaultDriver()
    {
        return $this->config->get('presenter');
    }
}
