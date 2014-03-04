<?php

namespace Twitter\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tweet
 */
class Tweet
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $message;

    /**
     * @var integer
     */
    private $parentId;

    /**
     * @var integer
     */
    private $userIdParent;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdAt;
    
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
     * Set message
     *
     * @param string $message
     * @return Tweet
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return Tweet
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set userIdParent
     *
     * @param integer $userIdParent
     * @return Tweet
     */
    public function setUserIdParent($userIdParent)
    {
        $this->userIdParent = $userIdParent;

        return $this;
    }

    /**
     * Get userIdParent
     *
     * @return integer 
     */
    public function getUserIdParent()
    {
        return $this->userIdParent;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Tweet
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Tweet
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param \Twitter\UserBundle\Entity\User $user
     * @return Tweet
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
