<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * @ORM\Table(name="`Orders`")
 * @Entity
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $currency;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $amount;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $totalAmount;


    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @var ArrayCollection $orderItems
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={"all"})
     */
    protected $orderItems;
    /**
     * Get id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get currency
     *
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set currency
     *
     * @param $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get amount
     *
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set amount
     *
     * @param $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return mixed
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set totalAmount
     *
     * @param $totalAmount
     * @return $this
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set created_at
     *
     * @param $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->createdAt = $created_at;
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updated_at
     *
     * @param $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updatedAt = $updated_at;
        return $this;
    }

    /**
     * Get status
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
       $this->status = $status;
       return $this;

    }

    /**
     * Get OrderItems
     *
     * @return OrderItem[]
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }
}
