<?php

namespace Notify\Filter;

use Notify\Manager\AbstractManager;

/**
 * @method \Notify\Filter\FilterInterface make($driver = null)
 */
final class FilterManager extends AbstractManager
{
    protected function getDefaultDriver()
    {
        return $this->config->get('default_filter', 'default');
    }
}
