<?php

namespace Ilios\CoreBundle\Tests\DataLoader;

class AuthenticationData extends AbstractDataLoader
{
    protected function getData()
    {
        $arr = array();

        $arr[] = array(
            'user' => 1,
            'username' => 'legacyuser',
            //legacyuserpass
            'passwordSha256' => '4e11be1dc9443935c7b452729ab681294b7cec9276d80dc72782221d68edb786',
            'passwordBcrypt' => null
        );

        $arr[] = array(
            'user' => 2,
            'username' => 'newuser',
            'passwordSha256' => null,
            //newuserpass
            'passwordBcrypt' => '$2a$10$CY96FLwV3dAA3hOLBHc/TeFZoaqH5/qlwNoFioj7dtKkKlVBTquve'
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
