<?php

namespace Notify\Storage\Filter;

use Notify\Envelope\Envelope;
use Notify\Storage\Filter\Specification\AndSpecification;
use Notify\Storage\Filter\Specification\OrSpecification;
use Notify\Storage\Filter\Specification\PrioritySpecification;
use Notify\Storage\Filter\Specification\SpecificationInterface;

final class FilterBuilder
{
    const ASC  = 'ASC';
    const DESC = 'DESC';

    /**
     * @var \Notify\Storage\Filter\Specification\SpecificationInterface
     */
    private $specification;

    /**
     * @var array<string, string>
     */
    private $orderings = array();

    /**
     * @var int|null
     */
    private $maxResults;

    public function orderBy(array $orderings)
    {
        $this->orderings = array_map(
            static function ($ordering) {
                return strtoupper($ordering) === FilterBuilder::ASC ? FilterBuilder::ASC : FilterBuilder::DESC;
            },
            $orderings
        );

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getOrderings()
    {
        return $this->orderings;
    }

    public function filter(array $envelopes)
    {
        $specification = $this->getWhereSpecification();

        if (null !== $specification) {
            $envelopes = array_filter(
                $envelopes,
                static function (Envelope $envelope) use ($specification) {
                    return $specification->isSatisfiedBy($envelope);
                }
            );
        }

        $length = $this->getMaxResults();

        if (null !== $length) {
            $envelopes = array_slice($envelopes, 0, $length, true);
        }

        return $envelopes;
    }

    /**
     * @return \Notify\Storage\Filter\Specification\SpecificationInterface
     */
    public function getWhereSpecification()
    {
        return $this->specification;
    }

    /**
     * @return int|null
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * @param int $maxResults
     *
     * @return $this
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;

        return $this;
    }

    public function wherePriority($minPriority, $maxPriority = null)
    {
        return $this->andWhere(new PrioritySpecification($minPriority, $maxPriority));
    }

    /**
     * @param \Notify\Storage\Filter\Specification\SpecificationInterface $specification
     *
     * @return $this
     */
    public function andWhere(SpecificationInterface $specification)
    {
        if ($this->specification === null) {
            return $this->where($specification);
        }

        $this->specification = new AndSpecification($this->specification, $specification);

        return $this;
    }

    /**
     * @param \Notify\Storage\Filter\Specification\SpecificationInterface $specification
     *
     * @return $this
     */
    public function where(SpecificationInterface $specification)
    {
        $this->specification = $specification;

        return $this;
    }

    public function orWherePriority($minPriority, $maxPriority = null)
    {
        return $this->orWhere(new PrioritySpecification($minPriority, $maxPriority));
    }

    /**
     * @param \Notify\Storage\Filter\Specification\SpecificationInterface $specification
     *
     * @return $this
     */
    public function orWhere(SpecificationInterface $specification)
    {
        if ($this->specification === null) {
            return $this->where($specification);
        }

        $this->specification = new OrSpecification($this->specification, $specification);

        return $this;
    }
}
