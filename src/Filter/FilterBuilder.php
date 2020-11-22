<?php

namespace Notify\Filter;

use Notify\Envelope\Envelope;
use Notify\Envelope\Stamp\OrderableStampInterface;
use Notify\Filter\Specification\AndSpecification;
use Notify\Filter\Specification\OrSpecification;
use Notify\Filter\Specification\SpecificationInterface;

final class FilterBuilder
{
    const ASC  = 'ASC';
    const DESC = 'DESC';

    /**
     * @var \Notify\Filter\Specification\SpecificationInterface
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

    public function withCriteria($criteria)
    {
        $criteriaBuilder = new CriteriaBuilder($this, $criteria);
        $criteriaBuilder->build();

        return $this;
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

        $orderings = $this->getOrderings();

        if (null !== $orderings) {
            foreach ($orderings as $field => $ordering) {
                usort($envelopes, static function (Envelope $a, Envelope $b) use ($field, $ordering) {
                    if (FilterBuilder::ASC === $ordering) {
                        list($a, $b) = array($b, $a);
                    }

                    $stampA = $a->get($field);
                    $stampB = $b->get($field);

                    if (!$stampA instanceof OrderableStampInterface) {
                        return 0;
                    }

                    return $stampA->compare($stampB);
                });
            }
        }

        $length = $this->getMaxResults();

        if (null !== $length) {
            $envelopes = array_slice($envelopes, 0, $length, true);
        }

        return $envelopes;
    }

    /**
     * @return \Notify\Filter\Specification\SpecificationInterface
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

    /**
     * @param \Notify\Filter\Specification\SpecificationInterface $specification
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
     * @param \Notify\Filter\Specification\SpecificationInterface $specification
     *
     * @return $this
     */
    public function where(SpecificationInterface $specification)
    {
        $this->specification = $specification;

        return $this;
    }

    /**
     * @param \Notify\Filter\Specification\SpecificationInterface $specification
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
