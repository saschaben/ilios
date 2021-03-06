<?php

namespace Ilios\CoreBundle\Entity;

/**
 * Interface AuthenticationInterface
 * @package Ilios\CoreBundle\Entity
 */
interface AuthenticationInterface
{
    /**
     * @param string $username
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $passwordSha256
     */
    public function setPasswordSha256($passwordSha256);

    /**
     * @return string
     */
    public function getPasswordSha256();

    /**
     * @param string $passwordBcrypt
     */
    public function setPasswordBcrypt($passwordBcrypt);

    /**
     * @return string
     */
    public function getPasswordBcrypt();

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();
}
