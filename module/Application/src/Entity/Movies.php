<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="movies")
 */
class Movies
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="integer", name="release_year")
     */
    private $releaseYear;

    /**
     * @ORM\Column(type="float",  name="movie_length")
     */
    private $movieLength;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    // Getters and setters

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getReleaseYear()
    {
        return $this->releaseYear;
    }

    public function setReleaseYear($releaseYear)
    {
        $this->releaseYear = $releaseYear;
        return $this;
    }

    public function getMovieLength()
    {
        return $this->movieLength;
    }

    public function setMovieLength($movieLength)
    {
        $this->movieLength = $movieLength;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }
}