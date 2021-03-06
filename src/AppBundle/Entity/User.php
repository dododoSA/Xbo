<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
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
     * @ORM\ManyToOne(targetEntity="Household", inversedBy="users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $household;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set household
     *
     * @param  $household
     *
     * @return User
     */
    public function setHousehold($household = null)
    {
        $this->household = $household;

        return $this;
    }

    /**
     * Get household
     *
     * @return 
     */
    public function getHousehold()
    {
        return $this->household;
    }
}
