<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Type;


/**
 * @ExclusionPolicy("all")
 */


class Sticker
{    /**
     * @var integer
     * @Expose
     */
    private $id;

    /**
     * @var integer
     * @Expose
     */
    private $view;

    /**
     * @var string
     * @Expose
     */
    private $color_0;

    /**
     * @var string
     * @Expose
     */
    private $color_1;

    /**
     * @var string
     * @Expose
     */
    private $color_2;

    /**
     * @var string
     * @Expose
     */
    private $message;

    /**
     * @var string
     * @Expose
     */
    private $username;

    /**
     * @var \DateTime
     * @Expose
     * @Type("DateTime<'d/m/Y'>")
     */
    private $creation_date;

    /**
     * @var \AppBundle\Entity\Donation
     * @Expose
     */
    private $donation;

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
     * Set view
     *
     * @param integer $view
     * @return Sticker
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return integer 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set color_0
     *
     * @param string $color0
     * @return Sticker
     */
    public function setColor0($color0)
    {
        $this->color_0 = $color0;

        return $this;
    }

    /**
     * Get color_0
     *
     * @return string 
     */
    public function getColor0()
    {
        return $this->color_0;
    }

    /**
     * Set color_1
     *
     * @param string $color1
     * @return Sticker
     */
    public function setColor1($color1)
    {
        $this->color_1 = $color1;

        return $this;
    }

    /**
     * Get color_1
     *
     * @return string 
     */
    public function getColor1()
    {
        return $this->color_1;
    }

    /**
     * Set color_2
     *
     * @param string $color2
     * @return Sticker
     */
    public function setColor2($color2)
    {
        $this->color_2 = $color2;

        return $this;
    }

    /**
     * Get color_2
     *
     * @return string 
     */
    public function getColor2()
    {
        return $this->color_2;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Sticker
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
     * Set username
     *
     * @param string $username
     * @return Sticker
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set creation_date
     *
     * @param \DateTime $creationDate
     * @return Sticker
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
        return $this->creation_date->format('d/m/Y');
    }

    /**
     * Set donation
     *
     * @param \AppBundle\Entity\Donation $donation
     * @return Sticker
     */
    public function setDonation(\AppBundle\Entity\Donation $donation = null)
    {
        $this->donation = $donation;

        return $this;
    }

    /**
     * Get donation
     *
     * @return \AppBundle\Entity\Donation 
     */
    public function getDonation()
    {
        return $this->donation;
    }
}
