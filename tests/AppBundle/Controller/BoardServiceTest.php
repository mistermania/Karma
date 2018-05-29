<?php
/**
 * Created by PhpStorm.
 * User: chamayou
 * Date: 29/05/2018
 * Time: 16:38
 */

namespace Tests\AppBundle\Controller;


use AppBundle\Model\CarteModel;
use AppBundle\Service\BoardService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BoardServiceTest extends WebTestCase
{
    public  function testGetPlayerCard(){
        $board[] = new CarteModel(0, 3, "trefle", "pickaxe", 0, "image");
        $board[] = new CarteModel(1, 4, "pique", "hand", 1, "image");
        $board[] = new CarteModel(2, 10, "coeur", "rest_up", 0, "image");
        $board[] = new CarteModel(3, 5, "carreau", "hand", 1, "image");
        $board[] = new CarteModel(4, 14, "trefle", "rest_down", 1, "image");
        $board[] = new CarteModel(4, 14, "pique", "rest_down", 2, "image");

        $boardService = new BoardService();


        $this->assertEquals(3,$boardService->getPlayerCard($board,1,"all"));


    }
}