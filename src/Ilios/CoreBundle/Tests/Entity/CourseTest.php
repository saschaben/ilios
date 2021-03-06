<?php
namespace Ilios\CoreBundle\Tests\Entity;

use Ilios\CoreBundle\Entity\Course;
use Mockery as m;

/**
 * Tests for Entity Course
 */
class CourseTest extends EntityBase
{
    /**
     * @var Course
     */
    protected $object;

    /**
     * Instantiate a Course object
     */
    protected function setUp()
    {
        $this->object = new Course;
    }

    public function testNotBlankValidation()
    {
        $notBlank = array(
            'title',
            'level',
            'year',
            'startDate',
            'endDate'
        );
        $this->validateNotBlanks($notBlank);

        $this->object->setTitle('test');
        $this->object->setLevel(3);
        $this->object->setYear(2004);
        $this->object->setStartDate(new \DateTime());
        $this->object->setEndDate(new \DateTime());
        $this->validate(0);
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::__construct
     */
    public function testConstructor()
    {
        $this->assertEmpty($this->object->getCohorts());
        $this->assertEmpty($this->object->getDirectors());
        $this->assertEmpty($this->object->getDisciplines());
        $this->assertEmpty($this->object->getMeshDescriptors());
        $this->assertEmpty($this->object->getObjectives());
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setTitle
     * @covers Ilios\CoreBundle\Entity\Course::getTitle
     */
    public function testSetTitle()
    {
        $this->basicSetTest('title', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setLevel
     * @covers Ilios\CoreBundle\Entity\Course::getLevel
     */
    public function testSetCourseLevel()
    {
        $this->basicSetTest('level', 'integer');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setYear
     * @covers Ilios\CoreBundle\Entity\Course::getYear
     */
    public function testSetYear()
    {
        $this->basicSetTest('year', 'integer');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setStartDate
     * @covers Ilios\CoreBundle\Entity\Course::getStartDate
     */
    public function testSetStartDate()
    {
        $this->basicSetTest('startDate', 'datetime');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setEndDate
     * @covers Ilios\CoreBundle\Entity\Course::getEndDate
     */
    public function testSetEndDate()
    {
        $this->basicSetTest('endDate', 'datetime');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setDeleted
     * @covers Ilios\CoreBundle\Entity\Course::isDeleted
     */
    public function testSetDeleted()
    {
        $this->booleanSetTest('deleted');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setId
     * @covers Ilios\CoreBundle\Entity\Course::getId
     */
    public function testSetExternalId()
    {
        $this->basicSetTest('externalId', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setLocked
     * @covers Ilios\CoreBundle\Entity\Course::isLocked
     */
    public function testSetLocked()
    {
        $this->booleanSetTest('locked');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setArchived
     * @covers Ilios\CoreBundle\Entity\Course::isArchived
     */
    public function testSetArchived()
    {
        $this->booleanSetTest('archived');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setOwningSchool
     * @covers Ilios\CoreBundle\Entity\Course::getOwningSchool
     */
    public function testSetOwningSchool()
    {
        $this->entitySetTest('owningSchool', 'School');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setClerkshipType
     * @covers Ilios\CoreBundle\Entity\Course::getClerkshipType
     */
    public function testSetClerkshipType()
    {
         $this->entitySetTest('clerkshipType', 'CourseClerkshipType');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::addDirector
     */
    public function testAddDirector()
    {
        $this->entityCollectionAddTest('director', 'User');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\Course::setPublishEvent
     * @covers Ilios\CoreBundle\Entity\Course::getPublishEvent
     */
    public function testSetPublishEvent()
    {
        $this->entitySetTest('publishEvent', 'PublishEvent');
    }
}
