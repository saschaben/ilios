<?php

namespace Ilios\CoreBundle\Tests\DataLoader;

class SessionLearningMaterialData extends AbstractDataLoader
{
    protected function getData()
    {
        $arr = array();

        $arr[] = array(
            'id' => 1,
            'required' => false,
            'publicNotes' => false,
            'session' => "1",
            'learningMaterial' => "1",
            'meshDescriptors' => []
        );


        return $arr;
    }

    public function create()
    {
        return [];
    }

    public function createInvalid()
    {
        return [];
    }
}
