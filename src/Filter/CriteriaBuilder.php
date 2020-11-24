<?php

namespace Notify\Filter;

use Notify\Filter\Specification\LifeSpecification;
use Notify\Filter\Specification\PrioritySpecification;

class CriteriaBuilder
{
    /**
     * @var \Notify\Filter\FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var array
     */
    private $criteria;

    public function __construct(FilterBuilder $filterBuilder, $criteria = array())
    {
        $this->filterBuilder = $filterBuilder;
        $this->criteria      = $criteria;
    }

    public function build()
    {
        $this->buildPriority();
        $this->buildLife();
        $this->buildLimit();
        $this->buildOrder();

        return $this->filterBuilder;
    }

    public function buildPriority()
    {
        if (!isset($this->criteria['priority'])) {
            return;
        }

        $priority = $this->criteria['priority'];

        if (!is_array($priority)) {
            $priority = array('min' => $priority);
        }

        $min = isset($priority['min']) ? $priority['min'] : null;
        $max = isset($priority['max']) ? $priority['max'] : null;

        $this->filterBuilder->andWhere(new PrioritySpecification($min, $max));
    }

    public function buildLife()
    {
        if (!isset($this->criteria['life'])) {
            return;
        }

        $life = $this->criteria['life'];

        if (!is_array($life)) {
            $life = array('min' => $life);
        }

        $min = isset($life['min']) ? $life['min'] : null;
        $max = isset($life['max']) ? $life['max'] : null;

        $this->filterBuilder->andWhere(new LifeSpecification($min, $max));
    }

    public function buildLimit()
    {
        if (!isset($this->criteria['limit'])) {
            return;
        }

        $this->filterBuilder->setMaxResults($this->criteria['limit']);
    }

    public function buildOrder()
    {
        if (!isset($this->criteria['order_by'])) {
            return;
        }

        $orderings = $this->criteria['order_by'];

        if (!is_array($orderings)) {
            $orderings = array($orderings => FilterBuilder::ASC);
        }

        $this->filterBuilder->orderBy($orderings);
    }
}
