<?php
/**
 * Created by PhpStorm.
 * User: chamayou
 * Date: 15/05/2018
 * Time: 16:08
 */

namespace AppBundle\Service;

use AppBundle\Model\CarteModel;
use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\AclBundle\Entity\Car;


//pickaxe,hand,rest_down,rest_up,current_card,played_card,bin


class BoardService
{

    function createBoard()
    {
        $board = new \ArrayObject();
        $index = 0;
        for ($i = 0; $i < 4; $i++) {
            for ($j = 2; $j < 15; $j++) {
                $color = "";
                $image = "";
                switch ($i) {
                    case 0:
                        $image = $j . "C.png";
                        $color = "trefle";
                        break;
                    case 1:
                        $image = $j . "S.png";
                        $color = "pique";
                        break;
                    case 2:
                        $image = $j . "D.png";
                        $color = "carreau";
                        break;
                    case 3:
                        $image = $j . "H.png";
                        $color = "coeur";
                        break;
                }

                $board[] = new CarteModel($index, $j, $color, "pickaxe", 0, $image);
                $index = $index + 1;
            }
        }


        return $board;
    }

    function initialiseBoard($board, $nb_players)
    {
        for ($i = 1; $i <= $nb_players; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $rand = rand(0, 51);
                while ($board[$rand]->getPlayer() != 0) {
                    $rand = rand(0, 51);
                }
                $board[$rand]->setPlayer($i);
                if ($j < 3) {
                    $board[$rand]->setState("hand");
                } elseif ($j > 2 && $j < 6) {
                    $board[$rand]->setState("rest_down");
                } elseif ($j > 5) {
                    $board[$rand]->setState("rest_up");
                }
            }
        }
        dump($board);
        return $board;
    }

    function getRandCardNotUsed($board){
        $rand = rand(0, 51);
        while ($board[$rand]->getPlayer() != 0) {
            $rand = rand(0, 51);
        }
        return $board[$rand];
    }

    function takePlayedCard($board, $player)
    {
        foreach ($board as $card) {
            if ($card->getState() == "current_card" || $card->getState() == "played_card") {
                $card->setPlayer($player);
                $card->setState("hand");
            }
        }
        return $board;
    }

    function takePickaxe($board, $player)
    {
        $rand = rand(0, 51);
        while ($board[$rand]->getState() != "pickaxe") {
            $rand = rand(0, 51);
        }
        $board[$rand]->setPlayer($player);
        $board[$rand]->setState("hand");
        return $board;
    }

    function getPlayerCard($board, $player, $info)
    {
        $nb_card = 0;
        foreach ($board as $card) {
            if ($card->getPlayer() == $player) {
                if ($card->getState() == $info || $info == "all") {
                    $nb_card = $nb_card + 1;
                }
            }
        }
        return $nb_card;
    }

    function checkMove($board, $card_move)
    {
        $number = $card_move->getNumber();
        foreach ($board as $card) {
            if ($card->getState() == "current_card") {
                if (($number >= $card->getNumber() && $card->getNumber() != 9) || $number == 10 || $number == 2) {
                    return true;
                } elseif ($card->getNumber() == 9 && $number <= 9) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    function checkMoveCard($board, $card)
    {
        if ($card->getPlayer() != 0) {
            if ($card->getState() == "hand") {
                return true;
            } elseif ($card->getState() == "rest_up" && $this->getPlayerCard($board, $card->getPlayer(), "hand") == 0) {
                return true;
            } elseif ($card->getState() == "rest_down" && $this->getPlayerCard($board, $card->getPlayer(), "hand" && $this->getPlayerCard($board, $card->getPlayer(), "rest_up"))) {
                return true;
            }
        }
        return false;
    }

    function moveCard($board, $card)
    {
        if ($this->checkMoveCard($board, $card)) {
            if ($this->checkMove()) {
                return true;
            }
        }
        return false;
    }

    function cleanSendBoard($board, $player){
        $clean_board = $board;
        foreach ($clean_board as $card) {
            if ($card->getPlayer() != $player) {
                if ($card->getState() == "rest_down" || $card->getState() == "hand" || $card->getState() == "pickaxe") {
                    $card->setColor("hide");
                    $card->setNumber("hide");
                }
            }
        }
        return $clean_board;
    }

    function checkCard($board, $card_check){
        foreach ($board as $card) {
            if ($card == $card_check) {
                return true;
            }
        }
        return false;
    }

}