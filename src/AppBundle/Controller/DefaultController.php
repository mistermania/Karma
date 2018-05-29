<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Tests\Service;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Service\BoardService;
use AppBundle\Model\CarteModel;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $boardService = new BoardService();

        $board = $boardService->initialiseBoard($boardService->createBoard(),4);

        $boardService->takePickaxe($board,1);
        dump($boardService->getPlayerCard($board,1,"hand"));


        dump($boardService->getPlayerCard($board,1,"all"));

        dump($boardService->getPlayerCard($board,1,"hand"));

        $boardService->takePickaxe($board,1);
        dump($boardService->getPlayerCard($board,1,"hand"));

        dump($boardService->getPlayerCard($board,1,"rest_down"));

        dump($boardService->getPlayerCard($board,1,"rest_up"));

        dump($boardService->cleanSendBoard($board,1));

        $encoders=[new JsonEncoder()];
        $normalizers=[new ObjectNormalizer(),new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers,$encoders);
        dump($serializer->serialize($board,'json'));


        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);


    }

    /**
     * @Route("/game", name="game")
     */
    public function testAction(Request $request)
    {
        return $this->render('default/game.html.twig');
    }
}
