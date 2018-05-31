<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_in", type="date", nullable=true)
     */
    private $dateIn;

    /**
     * @var string
     *
     * @ORM\Column(name="board", type="text", length=65535)
     */
    private $board;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer", nullable = true)
     */
    private $state = true;

    /**
     * @var int
     *
     * @ORM\Column(name="tour", type="integer", nullable = true)
     */
    private $tourJoueur;

    /**
     * Get tourJoueur
     *
     * @return int
     */
    public function getTourJoueur()
    {
        return $this->tourJoueur;
    }

    /**
     * Set state
     *
     * @param int $tourJoueur
     *
     * @return Game
     */
    public function setTourJoueur($tourJoueur)
    {
        $this->tourJoueur = $tourJoueur;
    }

    /**
     * @var User
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="in_game")
     *
     */
    private $players;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateIn
     *
     * @param \DateTime $dateIn
     *
     * @return Game
     */
    public function setDateIn($dateIn)
    {
        $this->dateIn = $dateIn;

        return $this;
    }

    /**
     * Get dateIn
     *
     * @return \DateTime
     */
    public function getDateIn()
    {
        return $this->dateIn;
    }

    /**
     * Set board
     *
     * @param string $board
     *
     * @return Game
     */
    public function setBoard($board)
    {
        $this->board = $board;

        return $this;
    }

    /**
     * Get board
     *
     * @return string
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Set state
     *
     * @param int $state
     *
     * @return Game
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }
}

