<?php

namespace Yoeunes\Notify\Producer;

use Yoeunes\Notify\Manager\AbstractManager;

final class ProducerManager extends AbstractManager
{
    /**
     * Register an extension notifier resolver.
     *
     * @param string                     $driver
     * @param \Closure|ProducerInterface $resolver
     *
     * @return \Yoeunes\Notify\Producer\ProducerManager
     */
    public function extend($driver, $resolver)
    {
        if ($resolver instanceof ProducerInterface) {
            $resolver = function ($config) use ($resolver) {
                $resolver->setConfig($config);

                return $resolver;
            };
        }

        return parent::extend($driver, $resolver);
    }
}
