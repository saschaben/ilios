<?php

namespace Ilios\CoreBundle\Tests\DataLoader;

class AamcMethodData extends AbstractDataLoader
{
    protected function getData()
    {
        $arr = array();

        $arr[] = array(
            'id' => "AM001",
            'description' => $this->faker->text,
            'sessionTypes' => ['1','2']
        );

        $arr[] = array(
            'id' => "AM002",
            'description' => $this->faker->text,
            'sessionTypes' => ['1']
        );

        return $arr;
    }

    public function create()
    {
        return [
            'id' => $this->faker->text(9),
            'description' => $this->faker->text,
            'sessionTypes' => ['1']
        ];
    }

    public function createInvalid()
    {
        return [];
    }
}
