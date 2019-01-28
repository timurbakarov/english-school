<?php

namespace Tests\Unit\Infr\Repository;

use Tests\TestCase;
use Infr\Repository\IdTypeToAggregateMapper;

class IdTypeToAggregateMapperTest extends TestCase
{
    public function test_it_works()
    {
        $idToClassMapper = new IdTypeToAggregateMapper([
            IdClass::class => 'AggregateClassName',
        ]);

        $this->assertEquals('AggregateClassName', $idToClassMapper->map(new IdClass()));
    }

    public function test_it_throws_exception()
    {
        $this->expectExceptionMessage("Invalid id class");

        $idToClassMapper = new IdTypeToAggregateMapper([
            IdClass::class => 'AggregateClassName',
        ]);

        $idToClassMapper->map(new NotMappedIdClass());
    }

    public function test_config()
    {
        $map = config('repository.map');

        $idToClassMapper = new IdTypeToAggregateMapper($map);

        foreach($map as $id => $class) {
            if(is_array($class)) {
                foreach($class as $context => $class2) {
                    $this->assertEquals($class2, $idToClassMapper->map($id::generate(), $context));
                }
            } else {
                $this->assertEquals($class, $idToClassMapper->map($id::generate()));
            }
        }
    }
}

class IdClass
{

}

class NotMappedIdClass
{

}
