<?php

namespace Ilios\CoreBundle\Tests\DataLoader;

class CourseData extends AbstractDataLoader
{
    protected function getData()
    {
        $arr = array();

        $arr[] = array(
            'id' => 1,
            'title' => $this->faker->text(25),
            'level' => 1,
            'year' => 2013,
            'startDate' => "2013-09-01T00:00:00+00:00",
            'endDate' => "2013-12-14T00:00:00+00:00",
            'deleted' => false,
            'externalId' => $this->faker->text(10),
            'locked' => false,
            'archived' => false,
            'publishedAsTbd' => false,
            'owningSchool' => "1",
            'clerkshipType' => "1",
            'directors' => [],
            'cohorts' => [1],
            'disciplines' => [],
            'objectives' => [1],
            'meshDescriptors' => [],
            'learningMaterials' => ['1', '2'],
            'sessions' => [1]
        );

        $arr[] = array(
            'id' => 2,
            'title' => $this->faker->text(25),
            'level' => 1,
            'year' => 2013,
            'startDate' => "2013-09-01T00:00:00+00:00",
            'endDate' => "2013-12-14T00:00:00+00:00",
            'deleted' => false,
            'externalId' => $this->faker->text(10),
            'locked' => false,
            'archived' => false,
            'publishedAsTbd' => false,
            'owningSchool' => "1",
            'clerkshipType' => "1",
            'directors' => [],
            'cohorts' => [1],
            'disciplines' => [],
            'objectives' => [1],
            'meshDescriptors' => [],
            'learningMaterials' => [],
            'sessions' => []
        );


        return $arr;
    }

    public function create()
    {
        return [
            'id' => 3,
            'title' => $this->faker->text(25),
            'level' => 1,
            'year' => 2013,
            'startDate' => "2013-09-01T00:00:00+00:00",
            'endDate' => "2013-12-14T00:00:00+00:00",
            'deleted' => false,
            'externalId' => $this->faker->text(10),
            'locked' => false,
            'archived' => false,
            'publishedAsTbd' => false,
            'owningSchool' => "1",
            'clerkshipType' => "1",
            'directors' => [],
            'cohorts' => [1],
            'disciplines' => [],
            'objectives' => [1],
            'meshDescriptors' => [],
            'learningMaterials' => [],
            'sessions' => []
        ];
    }

    public function createInvalid()
    {
        return [];
    }
}
