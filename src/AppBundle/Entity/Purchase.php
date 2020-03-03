<?php 

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="purchase")
 * @ORM\Entity
 */

class Purchase {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * 購入数   
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="date")
     */
    private $purchasedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Household", inversedBy="purchases")
     * @ORM\JoinColumn(name="household_id", referencedColumnName="id")
     */
    private $household;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="purchases")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Purchase
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Purchase
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set purchasedAt
     *
     * @param \DateTime $purchasedAt
     *
     * @return Purchase
     */
    public function setPurchasedAt($purchasedAt)
    {
        $this->purchasedAt = $purchasedAt;

        return $this;
    }

    /**
     * Get purchasedAt
     *
     * @return \DateTime
     */
    public function getPurchasedAt()
    {
        return $this->purchasedAt;
    }

    /**
     * Set household
     *
     * @param \AppBundle\Entity\Household $household
     *
     * @return Purchase
     */
    public function setHousehold(\AppBundle\Entity\Household $household = null)
    {
        $this->household = $household;

        return $this;
    }

    /**
     * Get household
     *
     * @return \AppBundle\Entity\Household
     */
    public function getHousehold()
    {
        return $this->household;
    }

    /**
     * Set number.
     *
     * @param int $number
     *
     * @return Purchase
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    }
}
