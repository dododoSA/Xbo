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
     * @ORM\ManyToOne(targetEntity="Household", inversedBy="categories")
     * @ORM\JoinColumn(name="household_id", referencedColumnName="id")
     */
    private $household;

    /**
     * @ORM\OneToMany(targetEntity="Purchase", mappedBy="category")
     */
    private $purchases;

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
     * Constructor
     */
    public function __construct()
    {
        $this->purchases = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add purchase.
     *
     * @param \AppBundle\Entity\Purchase $purchase
     *
     * @return Category
     */
    public function addPurchase(\AppBundle\Entity\Purchase $purchase)
    {
        $this->purchases[] = $purchase;

        return $this;
    }

    /**
     * Remove purchase.
     *
     * @param \AppBundle\Entity\Purchase $purchase
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePurchase(\AppBundle\Entity\Purchase $purchase)
    {
        return $this->purchases->removeElement($purchase);
    }

    /**
     * Get purchases.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchases()
    {
        return $this->purchases;
    }
}
