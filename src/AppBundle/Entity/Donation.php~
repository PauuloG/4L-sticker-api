<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;


/**
 * @ExclusionPolicy("all")
 */

class Donation
{    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $paypalTransactionId;

    /**
     * @var \DateTime
     */
    private $creation_date;

    /**
     * @var \AppBundle\Entity\Sticker
     */
    private $sticker;

    public function __construct()
    {
        $this->setCreationDate();
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
     * Set amount
     *
     * @param float $amount
     * @return Donation
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set paypalTransactionId
     *
     * @param string $paypalTransactionId
     * @return Donation
     */
    public function setPaypalTransactionId($paypalTransactionId)
    {
        $this->paypalTransactionId = $paypalTransactionId;

        return $this;
    }

    /**
     * Get paypalTransactionId
     *
     * @return string 
     */
    public function getPaypalTransactionId()
    {
        return $this->paypalTransactionId;
    }

    /**
     * Set creation_date
     *
     * @param \DateTime $creationDate
     * @return Donation
     */
    public function setCreationDate()
    {
        $this->creation_date = new \DateTime('now');

        return $this;
    }

    /**
     * Get creation_date
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set sticker
     *
     * @param \AppBundle\Entity\Sticker $sticker
     * @return Donation
     */
    public function setSticker(\AppBundle\Entity\Sticker $sticker = null)
    {
        $this->sticker = $sticker;

        return $this;
    }

    /**
     * Get sticker
     *
     * @return \AppBundle\Entity\Sticker 
     */
    public function getSticker()
    {
        return $this->sticker;
    }
}
