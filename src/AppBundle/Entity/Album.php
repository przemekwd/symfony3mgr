<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Album
 */
class Album
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $releaseDate;

    /**
     * @var integer
     */
    private $recordYear;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tracks;

    /**
     * @var \AppBundle\Entity\Artist
     */
    private $artist;

    /**
     * @var \AppBundle\Entity\Distributor
     */
    private $distributor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $genres;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $mediums;

    /**
     * @var string
     */
    private $cover;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tracks = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->mediums = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Album
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Album
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Album
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set recordYear
     *
     * @param integer $recordYear
     *
     * @return Album
     */
    public function setRecordYear($recordYear)
    {
        $this->recordYear = $recordYear;

        return $this;
    }

    /**
     * Get recordYear
     *
     * @return integer
     */
    public function getRecordYear()
    {
        return $this->recordYear;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Album
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add track
     *
     * @param \AppBundle\Entity\Track $track
     *
     * @return Album
     */
    public function addTrack(Track $track)
    {
        $this->tracks[] = $track;

        return $this;
    }

    /**
     * Remove track
     *
     * @param \AppBundle\Entity\Track $track
     */
    public function removeTrack(Track $track)
    {
        $this->tracks->removeElement($track);
    }

    /**
     * Get tracks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * Set artist
     *
     * @param \AppBundle\Entity\Artist $artist
     *
     * @return Album
     */
    public function setArtist(Artist $artist = null)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return \AppBundle\Entity\Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set distributor
     *
     * @param \AppBundle\Entity\Distributor $distributor
     *
     * @return Album
     */
    public function setDistributor(Distributor $distributor = null)
    {
        $this->distributor = $distributor;

        return $this;
    }

    /**
     * Get distributor
     *
     * @return \AppBundle\Entity\Distributor
     */
    public function getDistributor()
    {
        return $this->distributor;
    }

    /**
     * Add medium
     *
     * @param \AppBundle\Entity\Medium $medium
     *
     * @return Album
     */
    public function addMedium(Medium $medium)
    {
        $this->mediums[] = $medium;

        return $this;
    }

    /**
     * Remove medium
     *
     * @param \AppBundle\Entity\Medium $medium
     */
    public function removeMedium(Medium $medium)
    {
        $this->mediums->removeElement($medium);
    }

    /**
     * Get mediums
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediums()
    {
        return $this->mediums;
    }

    /**
     * Set cover
     *
     * @param string $cover
     *
     * @return Album
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Add genre
     *
     * @param \AppBundle\Entity\Genre $genre
     *
     * @return Album
     */
    public function addGenre(Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param \AppBundle\Entity\Genre $genre
     */
    public function removeGenre(Genre $genre)
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    public function __toString()
    {
        return $this->title;
    }

}
