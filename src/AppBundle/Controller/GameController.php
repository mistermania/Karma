<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GameController extends Controller
{
    /**
     * @Route("/getBoard")
     */
    public function getBoardAction()
    {
        return $this->render('AppBundle:Game:get_board.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/sendBoard")
     */
    public function sendBoardAction()
    {
        return $this->render('AppBundle:Game:send_board.html.twig', array(
            // ...
        ));
    }

}
