<?php
namespace Ilios\CoreBundle\Tests\Entity;

use Ilios\CoreBundle\Entity\CurriculumInventoryAcademicLevel;
use Mockery as m;

/**
 * Tests for Entity CurriculumInventoryAcademicLevel
 */
class CurriculumInventoryAcademicLevelTest extends EntityBase
{
    /**
     * @var CurriculumInventoryAcademicLevel
     */
    protected $object;

    /**
     * Instantiate a CurriculumInventoryAcademicLevel object
     */
    protected function setUp()
    {
        $this->object = new CurriculumInventoryAcademicLevel;
    }

    public function testNotBlankValidation()
    {
        $notBlank = array(
            'name',
            'level'
        );
        $this->validateNotBlanks($notBlank);

        $this->object->setName('50 char max name test');
        $this->object->setLevel(4);
        $this->validate(0);
    }

    /**
     * @covers Ilios\CoreBundle\Entity\CurriculumInventoryAcademicLevel::setLevel
     * @covers Ilios\CoreBundle\Entity\CurriculumInventoryAcademicLevel::getLevel
     */
    public function testSetLevel()
    {
        $this->basicSetTest('level', 'integer');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\CurriculumInventoryAcademicLevel::setName
     * @covers Ilios\CoreBundle\Entity\CurriculumInventoryAcademicLevel::getName
     */
    public function testSetName()
    {
        $this->basicSetTest('name', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\CurriculumInventoryAcademicLevel::setDescription
     * @covers Ilios\CoreBundle\Entity\CurriculumInventoryAcademicLevel::getDescription
     */
    public function testSetDescription()
    {
        $this->basicSetTest('description', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\CurriculumInventoryAcademicLevel::setReport
     * @covers Ilios\CoreBundle\Entity\CurriculumInventoryAcademicLevel::getReport
     */
    public function testSetReport()
    {
        $this->entitySetTest('report', 'CurriculumInventoryReport');
    }
}
