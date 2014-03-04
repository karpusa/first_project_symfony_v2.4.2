<?php

namespace Twitter\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Like
 */
class Like
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Twitter\UserBundle\Entity\User
     */
    private $userFollow;

    /**
     * @var \Twitter\UserBundle\Entity\User
     */
    private $user;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userFollow
     *
     * @param \Twitter\UserBundle\Entity\User $userFollow
     * @return Like
     */
    public function setUserFollow(\Twitter\UserBundle\Entity\User $userFollow = null)
    {
        $this->userFollow = $userFollow;

        return $this;
    }

    /**
     * Get userFollow
     *
     * @return \Twitter\UserBundle\Entity\User 
     */
    public function getUserFollow()
    {
        return $this->userFollow;
    }

    /**
     * Set user
     *
     * @param \Twitter\UserBundle\Entity\User $user
     * @return Like
     */
    public function setUser(\Twitter\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Twitter\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
