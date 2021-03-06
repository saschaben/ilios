<?php
namespace Ilios\CoreBundle\Tests\Entity;

use Ilios\CoreBundle\Entity\MeshConcept;
use Mockery as m;

/**
 * Tests for Entity MeshConcept
 */
class MeshConceptTest extends EntityBase
{
    /**
     * @var MeshConcept
     */
    protected $object;

    /**
     * Instantiate a MeshConcept object
     */
    protected function setUp()
    {
        $this->object = new MeshConcept;
    }

    public function testNotBlankValidation()
    {
        $notBlank = array(
            'name',
            'umlsUid'
        );
        $this->validateNotBlanks($notBlank);

        $this->object->setName('test_name');
        $this->object->setUmlsUid('whatthe_');
        $this->validate(0);
    }

    /**
     * @covers Ilios\CoreBundle\Entity\MeshConcept::__construct
     */
    public function testConstructor()
    {
        $now = new \DateTime();
        $createdAt = $this->object->getCreatedAt();
        $this->assertTrue($createdAt instanceof \DateTime);
        $diff = $now->diff($createdAt);
        $this->assertTrue($diff->s < 2);

    }

    /**
     * @covers Ilios\CoreBundle\Entity\MeshConcept::setName
     * @covers Ilios\CoreBundle\Entity\MeshConcept::getName
     */
    public function testSetName()
    {
        $this->basicSetTest('name', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\MeshConcept::setUmlsUid
     * @covers Ilios\CoreBundle\Entity\MeshConcept::getUmlsUid
     */
    public function testSetUmlsUid()
    {
        $this->basicSetTest('umlsUid', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\MeshConcept::setPreferred
     * @covers Ilios\CoreBundle\Entity\MeshConcept::getPreferred
     */
    public function testSetPreferred()
    {
        $this->basicSetTest('preferred', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\MeshConcept::setScopeNote
     * @covers Ilios\CoreBundle\Entity\MeshConcept::getScopeNote
     */
    public function testSetScopeNote()
    {
        $this->basicSetTest('scopeNote', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\MeshConcept::setCasn1Name
     */
    public function testSetCasn1Name()
    {
        $this->basicSetTest('casn1Name', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\MeshConcept::setRegistryNumber
     * @covers Ilios\CoreBundle\Entity\MeshConcept::getRegistryNumber
     */
    public function testSetRegistryNumber()
    {
        $this->basicSetTest('registryNumber', 'string');
    }

    /**
     * @covers Ilios\CoreBundle\Entity\MeshConcept::stampUpdate
     */
    public function testStampUpdate()
    {
        $now = new \DateTime();
        $this->object->stampUpdate();
        $updatedAt = $this->object->getUpdatedAt();
        $this->assertTrue($updatedAt instanceof \DateTime);
        $diff = $now->diff($updatedAt);
        $this->assertTrue($diff->s < 2);

    }
}
