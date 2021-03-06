<?php

namespace Ilios\CoreBundle\Tests\DataLoader;

class CohortData extends AbstractDataLoader
{
    protected function getData()
    {
        $arr = array();

        $arr[] = array(
            'id' => 1,
            'title' => "Class of 2017",
            'programYear' => "1",
            'courses' => ['1', '2'],
            'learnerGroups' => [1],
            'users' => [1]
        );

        $arr[] = array(
            'id' => 2,
            'title' => "Class of 2018",
            'programYear' => "2",
            'courses' => [],
            'learnerGroups' => [],
            'users' => []
        );


        return $arr;
    }

    public function create()
    {
        return [
            'id' => 3,
            'title' => $this->faker->text(15),
            'programYear' => "3",
            'courses' => [],
            'learnerGroups' => [],
            'users' => []
        ];
    }

    public function createInvalid()
    {
        return [
            'id' => 'string',
            'title' => null,
            'programYear' => null
        ];
    }
}
