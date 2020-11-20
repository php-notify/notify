<?php

namespace Notify\Presenter;

use InvalidArgumentException;
use Notify\Manager\AbstractManager;

final class PresenterManager extends AbstractManager
{
    public function makeFromContext(array $context)
    {
        foreach ($this->drivers as $presenter) {
            if ($presenter->support($context)) {
                return $presenter;
            }
        }

        throw new InvalidArgumentException(sprintf('No presenter found for the given context'));
    }
}
