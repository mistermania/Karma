<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FosUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends FosUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Collection
     *
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="players")
     * @ORM\JoinColumn(name="in_game", referencedColumnName="id")
     */
    protected $in_game = null;

    /**
     * @var bool
     *
     * @ORM\Column(name="want_play", type="boolean", )
     */
    private $want_play = false;

    /**
     * @return bool
     */
    public function isWantPlay()
    {
        return $this->want_play;
    }

    /**
     * @param bool $want_play
     */
    public function setWantPlay($want_play)
    {
        $this->want_play = $want_play;
    }

    /**
     * @return Collection
     */
    public function getInGame()
    {
        return $this->in_game;
    }

    /**
     * @param Collection $in_game
     */
    public function setInGame($in_game)
    {
        $this->in_game = $in_game;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        parent::__construct();
    }

}

