<?php
namespace Ilios\CoreBundle\Tests\Entity;

use Ilios\CoreBundle\Entity\InstructorGroup;
use Mockery as m;

/**
 * Tests for Entity InstructorGroup
 */
class InstructorGroupTest extends EntityBase
{
    /**
     * @var InstructorGroup
     */
    protected $object;

    /**
     * Instantiate a InstructorGroup object
     */
    protected function setUp()
    {
        $this->object = new InstructorGroup;
    }

    public function testNotBlankValidation()
    {
        $notBlank = array(
            'title'
        );
        $this->validateNotBlanks($notBlank);

        $this->object->setTitle('test');
        $this->validate(0);
    }
    /**
     * @covers Ilios\CoreBundle\Entity\InstructorGroup::__construct
     */
    public function testConstructor()
    {
        $this->assertEmpty($this->object->getLearnerGroups());
        $this->assertEmpty($this->object->getIlmSessions());
        $this->assertEmpty($this->object->getOfferings());
        $this->assertEmpty($this->object->getUsers());
    }

    /**
     * @covers Ilios\CoreBundle\Entity\InstructorGroup::addLearnerGroup
     */
    public function testAddLearnerGroup()
    {
        $this->entityCollectionAddTest('learnerGroup', 'LearnerGroup');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\InstructorGroup::getLearnerGroups
     */
    public function testGetLearnerGroups()
    {
        $this->entityCollectionSetTest('learnerGroup', 'LearnerGroup');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\InstructorGroup::addIlmSession
     */
    public function testAddIlmSession()
    {
        $this->entityCollectionAddTest('ilmSession', 'IlmSessionFacet');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\InstructorGroup::getIlmSessions
     */
    public function testGetIlmSessions()
    {
        $this->entityCollectionSetTest('ilmSession', 'IlmSessionFacet');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\InstructorGroup::addUser
     */
    public function testAddUser()
    {
        $this->entityCollectionAddTest('user', 'User');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\InstructorGroup::getUsers
     */
    public function testGetUsers()
    {
        $this->entityCollectionSetTest('user', 'User');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\InstructorGroup::addOffering
     */
    public function testAddOffering()
    {
        $this->entityCollectionAddTest('offering', 'Offering');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\InstructorGroup::getOfferings
     */
    public function testGetOfferings()
    {
        $this->entityCollectionSetTest('offering', 'Offering');
    }
}
