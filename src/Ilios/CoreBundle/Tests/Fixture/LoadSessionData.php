<?php

namespace Ilios\CoreBundle\Tests\Fixture;

use Ilios\CoreBundle\Entity\Session;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSessionData extends AbstractFixture implements
    FixtureInterface,
    DependentFixtureInterface,
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
            ->get('ilioscore.dataloader.session')
            ->getAll();
        foreach ($data as $arr) {
            $entity = new Session();
            $entity->setId($arr['id']);
            $entity->setTitle($arr['title']);
            $entity->setSessionType($this->getReference('sessionTypes' . $arr['sessionType']));
            $entity->setCourse($this->getReference('courses' . $arr['course']));
            $entity->setPublishEvent($this->getReference('publishEvents' . $arr['publishEvent']));
            $entity->setIlmSessionFacet($this->getReference('ilmSessions' . $arr['ilmSessionFacet']));
            $related = array(
                'disciplines' => 'addDiscipline',
                'objectives' => 'addObjective'
            );
            foreach ($related as $key => $method) {
                foreach ($arr[$key] as $id) {
                    $entity->$method($this->getReference($key . $id));
                }
            }
            $manager->persist($entity);
            
            $this->addReference('sessions' . $arr['id'], $entity);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            'Ilios\CoreBundle\Tests\Fixture\LoadSessionTypeData',
            'Ilios\CoreBundle\Tests\Fixture\LoadCourseData',
            'Ilios\CoreBundle\Tests\Fixture\LoadObjectiveData',
            'Ilios\CoreBundle\Tests\Fixture\LoadPublishEventData',
            'Ilios\CoreBundle\Tests\Fixture\LoadIlmSessionData',
        );
    }
}
