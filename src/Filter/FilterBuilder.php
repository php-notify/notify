<?php

namespace Yoeunes\Notify\Filter;

use Yoeunes\Notify\Envelope\Envelope;
use Yoeunes\Notify\Filter\Specification\AndSpecification;
use Yoeunes\Notify\Filter\Specification\OrSpecification;
use Yoeunes\Notify\Filter\Specification\PrioritySpecification;
use Yoeunes\Notify\Filter\Specification\SpecificationInterface;

final class FilterBuilder
{
    const ASC  = 'ASC';
    const DESC = 'DESC';

    /**
     * @var \Yoeunes\Notify\Filter\Specification\SpecificationInterface
     */
    private $specification;

    /**
     * @var array<string, string>
     */
    private $orderings = array();

    /**
     * @var null|int
     */
    private $maxResults;

    /**
     * @param \Yoeunes\Notify\Filter\Specification\SpecificationInterface $specification
     *
     * @return $this
     */
    public function where(SpecificationInterface $specification)
    {
        $this->specification = $specification;

        return $this;
    }

    /**
     * @param \Yoeunes\Notify\Filter\Specification\SpecificationInterface $specification
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
     * @param \Yoeunes\Notify\Filter\Specification\SpecificationInterface $specification
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
     * @return null|int
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

    /**
     * @return \Yoeunes\Notify\Filter\Specification\SpecificationInterface
     */
    public function getWhereSpecification()
    {
        return $this->specification;
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
            $envelopes = array_filter($envelopes, function (Envelope $envelope) use ($specification) {
                return $specification->isSatisfiedBy($envelope);
            });
        }

        $length = $this->getMaxResults();

        if (null !== $length) {
            $envelopes = array_slice($envelopes, 0, $length, true);
        }

        return $envelopes;
    }

    public function wherePriority($minPriority, $maxPriority = null)
    {
        return $this->andWhere(new PrioritySpecification($minPriority, $maxPriority));
    }

    public function orWherePriority($minPriority, $maxPriority = null)
    {
        return $this->orWhere(new PrioritySpecification($minPriority, $maxPriority));
    }
}
