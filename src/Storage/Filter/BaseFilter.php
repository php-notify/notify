<?php

namespace Yoeunes\Notify\Storage\Filter;

use Yoeunes\Notify\Storage\StorageInterface;

class BaseFilter implements FilterInterface
{
    private $storage;
    private $filter;
    private $options;

    public function __construct(StorageInterface $storage, FilterBuilder $filter, array $options)
    {
        $this->storage = $storage;
        $this->filter = $filter;
        $this->options = $options;
    }

    public function getEnvelopes()
    {
        $envelopes = $this->storage->get();

        dump($envelopes);
        
        $minPriority = isset($this->options['priority']['min']) ? $this->options['priority']['min'] : null;
        $maxPriority = isset($this->options['priority']['max']) ? $this->options['priority']['max'] : null;

        if (null !== $minPriority || null !== $maxPriority) {
            $this->filter->wherePriority($minPriority, $maxPriority);
        }

        if (isset($this->options['max_results'])) {
            $this->filter->setMaxResults($this->options['max_results']);
        }

        return $this->filter->filter($envelopes);
    }
}
