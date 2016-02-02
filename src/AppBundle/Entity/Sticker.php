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


class Sticker
{
    /**
     * @var integer
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
    private $colors;

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
     * @var \AppBundle\Entity\Donation
     */
    private $donation;


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
     * Set colors
     *
     * @param string $colors
     * @return Sticker
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Get colors
     *
     * @return string 
     */
    public function getColors()
    {
        return $this->colors;
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
