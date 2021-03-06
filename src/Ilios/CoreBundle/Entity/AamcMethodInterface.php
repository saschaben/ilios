<?php

namespace Ilios\CoreBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Ilios\CoreBundle\Entity\SessionTypeInterface;

use Ilios\CoreBundle\Traits\DescribableEntityInterface;
use Ilios\CoreBundle\Traits\IdentifiableEntityInterface;

/**
 * Interface AamcMethodInterface
 * @package Ilios\CoreBundle\Entity
 */
interface AamcMethodInterface extends
    IdentifiableEntityInterface,
    DescribableEntityInterface
{
    /**
     * @param Collection $sessionTypes
     */
    public function setSessionTypes(Collection $sessionTypes);

    /**
     * @param SessionTypeInterface $sessionType
     */
    public function addSessionType(SessionTypeInterface $sessionType);

    /**
     * @return ArrayCollection|SessionTypeInterface[]
     */
    public function getSessionTypes();
}
