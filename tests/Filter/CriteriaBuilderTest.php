<?php

namespace Notify\Tests\Filter;

use Notify\Filter\CriteriaBuilder;
use Notify\Filter\FilterBuilder;
use Notify\Filter\Specification\AndSpecification;
use Notify\Filter\Specification\LifeSpecification;
use Notify\Filter\Specification\PrioritySpecification;
use Notify\Tests\TestCase;

final class CriteriaBuilderTest extends TestCase
{
    public function testCriteria()
    {
        $criteria = new CriteriaBuilder(new FilterBuilder(), array(
            'priority' => 1,
            'life' => 2,
            'limit' => 2,
            'order_by' => 'Notify\Envelope\Stamp\LifeStamp',
        ));

        $this->assertInstanceOf('Notify\Filter\FilterBuilder', $criteria->build());
        $this->assertNotEmpty($criteria->build()->getSpecification());
    }

    public function testWithoutPriority()
    {
        $criteria = new CriteriaBuilder(new FilterBuilder(), array());

        $this->assertInstanceOf('Notify\Filter\FilterBuilder', $criteria->build());
        $this->assertEmpty($criteria->build()->getSpecification());
    }
}
