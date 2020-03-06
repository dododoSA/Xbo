<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="category")
 * @ORM\Entity
 */

class Category {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity="Household", inversedBy="categories")
     * @ORM\JoinColumn(name="household_id", referencedColumnName="id")
     */
    private $household;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set household.
     *
     * @param \AppBundle\Entity\Household|null $household
     *
     * @return Category
     */
    public function setHousehold(\AppBundle\Entity\Household $household = null)
    {
        $this->household = $household;

        return $this;
    }

    /**
     * Get household.
     *
     * @return \AppBundle\Entity\Household|null
     */
    public function getHousehold()
    {
        return $this->household;
    }

    /**
     * Set color.
     *
     * @param string $color
     *
     * @return Category
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}
