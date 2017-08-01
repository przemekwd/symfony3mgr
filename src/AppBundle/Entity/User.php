<?php

namespace AppBundle\Entity;

/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $gender;


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
     * Set gender
     *
     * @param boolean $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return boolean
     */
    public function getGender()
    {
        return $this->gender;
    }
}

