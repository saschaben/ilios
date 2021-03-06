<?php

namespace Ilios\CoreBundle\Entity\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Id\AssignedGenerator;
use Ilios\CoreBundle\Entity\ReportPoValueInterface;

/**
 * Class ReportPoValueManager
 * @package Ilios\CoreBundle\Entity\Manager
 */
class ReportPoValueManager implements ReportPoValueManagerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * @param Registry $em
     * @param string $class
     */
    public function __construct(Registry $em, $class)
    {
        $this->em         = $em->getManagerForClass($class);
        $this->class      = $class;
        $this->repository = $em->getRepository($class);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     *
     * @return ReportPoValueInterface
     */
    public function findReportPoValueBy(
        array $criteria,
        array $orderBy = null
    ) {
        return $this->repository->findOneBy($criteria, $orderBy);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param integer $limit
     * @param integer $offset
     *
     * @return ArrayCollection|ReportPoValueInterface[]
     */
    public function findReportPoValuesBy(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null
    ) {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param ReportPoValueInterface $reportPoValue
     * @param bool $andFlush
     * @param bool $forceId
     */
    public function updateReportPoValue(
        ReportPoValueInterface $reportPoValue,
        $andFlush = true,
        $forceId = false
    ) {
        $this->em->persist($reportPoValue);

        if ($forceId) {
            $metadata = $this->em->getClassMetaData(get_class($reportPoValue));
            $metadata->setIdGenerator(new AssignedGenerator());
        }

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * @param ReportPoValueInterface $reportPoValue
     */
    public function deleteReportPoValue(
        ReportPoValueInterface $reportPoValue
    ) {
        $this->em->remove($reportPoValue);
        $this->em->flush();
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return ReportPoValueInterface
     */
    public function createReportPoValue()
    {
        $class = $this->getClass();
        return new $class();
    }
}
