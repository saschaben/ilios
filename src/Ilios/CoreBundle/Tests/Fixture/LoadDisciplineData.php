<?php

namespace Ilios\CoreBundle\Tests\Fixture;

use Ilios\CoreBundle\Entity\Discipline;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadDisciplineData extends AbstractFixture implements
    FixtureInterface,
    ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $data = $this->container
            ->get('ilioscore.dataloader.discipline')
            ->getAll();
        foreach ($data as $arr) {
            $entity = new Discipline();
            $entity->setId($arr['id']);
            $manager->persist($entity);
            $this->addReference('disciplines' . $arr['id'], $entity);
        }

        $manager->flush();
    }
}
