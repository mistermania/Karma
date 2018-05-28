<?php
/**
 * Created by PhpStorm.
 * User: chamayou
 * Date: 14/05/2018
 * Time: 21:22
 */

namespace AppBundle\Model;


class CarteModel
{
    private $_id;
    private $_number;
    private $_color;
    private $_state;
    private $_player;

    function __construct($id,$number,$color,$state,$player)
    {
        $this->_id = $id;
        $this->_number = $number;
        $this->_color = $color;
        $this->_state = $state;
        $this->_player = $player;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->_color;
    }

    /**
     * @param mixed $couleur
     */
    public function setColor($couleur)
    {
        $this->_color = $couleur;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * @param mixed $statut
     */
    public function setState($statut)
    {
        $this->_state = $statut;
    }

    /**
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->_player;
    }

    /**
     * @param mixed $joueur
     */
    public function setPlayer($joueur)
    {
        $this->_player = $joueur;
    }


    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * @param mixed $nombre
     */
    public function setNumber($nombre)
    {
        $this->_number = $nombre;
    }

}
use Symfony\Component\EventDispatcher\Tests\Service;
use Symfony\Component\Serializer\Tests\Model;