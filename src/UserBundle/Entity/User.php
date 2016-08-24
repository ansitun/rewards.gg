<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="giveaway_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $full_name;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
     
    /**
     * Set full_name.
     *
     * @param string $full_name
     *
     * @return User
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;

        return $this;
    }

    /**
     * Get full_name.
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->full_name;
    }
}