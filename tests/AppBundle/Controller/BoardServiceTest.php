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
    public function testGetPlayerCard()
    {
        $board[] = new CarteModel(0, 3, "trefle", "pickaxe", 0, "image");
        $board[] = new CarteModel(1, 4, "pique", "hand", 1, "image");
        $board[] = new CarteModel(2, 10, "coeur", "rest_up", 0, "image");
        $board[] = new CarteModel(3, 5, "carreau", "hand", 1, "image");
        $board[] = new CarteModel(4, 14, "trefle", "rest_down", 1, "image");
        $board[] = new CarteModel(4, 14, "pique", "rest_down", 2, "image");

        $boardService = new BoardService();

        $this->assertEquals(3, $boardService->getPlayerCard($board, 1, "all"));
        $this->assertEquals(2, $boardService->getPlayerCard($board, 1, "hand"));
        $this->assertEquals(0, $boardService->getPlayerCard($board, 1, "rest_up"));
        $this->assertEquals(1, $boardService->getPlayerCard($board, 1, "rest_down"));
        $this->assertEquals(1, $boardService->getPlayerCard($board, 2, "rest_down"));
    }


    public function testCheckMoveCard()
    {
        $board[] = new CarteModel(0, 3, "trefle", "pickaxe", 0, "image");
        $board[] = new CarteModel(1, 4, "pique", "hand", 1, "image");
        $board[] = new CarteModel(2, 10, "coeur", "rest_up", 0, "image");
        $board[] = new CarteModel(3, 5, "carreau", "hand", 1, "image");
        $board[] = new CarteModel(4, 14, "trefle", "rest_down", 1, "image");
        $board[] = new CarteModel(4, 14, "pique", "rest_down", 2, "image");

        $boardService = new BoardService();

        $this->assertEquals(true, $boardService->checkMoveCard($board, $board[1]));
        $this->assertEquals(false, $boardService->checkMoveCard($board, $board[4]));
        $this->assertEquals(false, $boardService->checkMoveCard($board, $board[0]));
    }



    public function testCheckMove()
    {
        $board[] = new CarteModel(0, 6, "trefle", "current_card", 0, "image");
        $board[] = new CarteModel(1, 4, "pique", "hand", 1, "image");
        $board[] = new CarteModel(2, 10, "coeur", "rest_up", 0, "image");
        $board[] = new CarteModel(3, 7, "carreau", "hand", 1, "image");
        $board[] = new CarteModel(4, 14, "trefle", "rest_down", 1, "image");
        $board[] = new CarteModel(4, 14, "pique", "rest_down", 2, "image");

        $boardService = new BoardService();

        $this->assertEquals(false, $boardService->checkMove($board, $board[1]));
        $this->assertEquals(true, $boardService->checkMove($board, $board[4]));
    }

    public function testMoveCard(){
        $board[] = new CarteModel(0, 6, "trefle", "current_card", 0, "image");
        $board[] = new CarteModel(1, 4, "pique", "hand", 1, "image");
        $board[] = new CarteModel(2, 10, "coeur", "rest_up", 0, "image");
        $board[] = new CarteModel(3, 7, "carreau", "hand", 1, "image");
        $board[] = new CarteModel(4, 14, "trefle", "rest_down", 1, "image");
        $board[] = new CarteModel(4, 14, "pique", "rest_down", 2, "image");

        $boardService = new BoardService();

        $this->assertEquals(false, $boardService->moveCard($board, $board[1]));
        $this->assertEquals(false, $boardService->moveCard($board, $board[4]));
        $this->assertEquals(true, $boardService->moveCard($board, $board[3]));
    }

    public function testChangeCurrentCard(){
        $board[] = new CarteModel(0, 6, "trefle", "current_card", 0, "image");
        $board[] = new CarteModel(1, 4, "pique", "hand", 1, "image");

        $boardService = new BoardService();

        $boardService->changeCurrentCard($board,1);
        $this->assertEquals("current_card",$board[1]->getState());

    }


    public function testCleanSendBoard(){
        $board[] = new CarteModel(0, 6, "trefle", "current_card", 0, "image");
        $board[] = new CarteModel(1, 4, "pique", "hand", 1, "image");
        $board[] = new CarteModel(2, 10, "coeur", "rest_up", 0, "image");
        $board[] = new CarteModel(3, 7, "carreau", "hand", 1, "image");
        $board[] = new CarteModel(4, 14, "trefle", "rest_down", 1, "image");
        $board[] = new CarteModel(4, 14, "pique", "rest_down", 2, "image");

        $boardService = new BoardService();

        $boardService->cleanSendBoard($board,1);

        $this->assertEquals("hide", $board[5]->getNumber());
        $this->assertNotEquals("hide", $board[1]->getNumber());
    }


    public function testTakePlayedCard(){
        $board[] = new CarteModel(0, 6, "trefle", "current_card", 0, "image");
        $board[] = new CarteModel(1, 4, "pique", "hand", 1, "image");
        $board[] = new CarteModel(2, 10, "coeur", "played_card", 0, "image");
        $board[] = new CarteModel(3, 7, "carreau", "played_card", 0, "image");
        $board[] = new CarteModel(4, 14, "trefle", "rest_down", 1, "image");
        $board[] = new CarteModel(4, 14, "pique", "rest_down", 2, "image");

        $boardService = new BoardService();

        $this->assertEquals(1, $boardService->getPlayerCard($board,1,"hand"));

        $boardService->takePlayedCard($board,1);

        $this->assertEquals(4, $boardService->getPlayerCard($board,1,"hand"));
    }


    public function testTakePickaxe(){
        $board[] = new CarteModel(0, 6, "trefle", "current_card", 0, "image");
        $board[] = new CarteModel(1, 4, "pique", "hand", 1, "image");
        $board[] = new CarteModel(2, 10, "coeur", "pickaxe", 0, "image");
        $board[] = new CarteModel(3, 7, "carreau", "pickaxe", 0, "image");
        $board[] = new CarteModel(4, 14, "trefle", "rest_down", 1, "image");
        $board[] = new CarteModel(4, 14, "pique", "rest_down", 2, "image");

        $boardService = new BoardService();

        $this->assertEquals(1, $boardService->getPlayerCard($board,1,"hand"));

        $boardService->takePickaxe($board,1);

        $this->assertEquals(2, $boardService->getPlayerCard($board,1,"hand"));
    }
}