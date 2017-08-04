<?php

namespace AppBundle\Entity;

/**
 * Genre
 */
class Genre
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name_pl;

    /**
     * @var string
     */
    private $name_en;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $albums;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->albums = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set namePl
     *
     * @param string $namePl
     *
     * @return Genre
     */
    public function setNamePl($namePl)
    {
        $this->name_pl = $namePl;

        return $this;
    }

    /**
     * Get namePl
     *
     * @return string
     */
    public function getNamePl()
    {
        return $this->name_pl;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     *
     * @return Genre
     */
    public function setNameEn($nameEn)
    {
        $this->name_en = $nameEn;

        return $this;
    }

    /**
     * Get nameEn
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->name_en;
    }

    /**
     * Add album
     *
     * @param \AppBundle\Entity\Album $album
     *
     * @return Genre
     */
    public function addAlbum(\AppBundle\Entity\Album $album)
    {
        $this->albums[] = $album;

        return $this;
    }

    /**
     * Remove album
     *
     * @param \AppBundle\Entity\Album $album
     */
    public function removeAlbum(\AppBundle\Entity\Album $album)
    {
        $this->albums->removeElement($album);
    }

    /**
     * Get albums
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    public function __toString()
    {
        return $this->name_pl;
    }
}
