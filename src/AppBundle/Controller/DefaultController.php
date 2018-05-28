<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Tests\Service;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Service\BoardService;
use AppBundle\Model\CarteModel;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $board = new BoardService();

        $current_board = $board->initialiseBoard($board->createBoard(),4);

        $board->takePickaxe($current_board,1);


        dump($board->getPlayerCard($current_board,1,"all"));

        dump($board->getPlayerCard($current_board,1,"hand"));

        dump($board->getPlayerCard($current_board,1,"rest_down"));

        dump($board->getPlayerCard($current_board,1,"rest_up"));


        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


}
