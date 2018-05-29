<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use ClassesWithParents\G;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Tests\Service;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Service\BoardService;
use AppBundle\Model\CarteModel;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
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
        /*
        $board = new BoardService();

        $board = $boardService->initialiseBoard($boardService->createBoard(),4);

        $boardService->takePickaxe($board,1);
        dump($boardService->getPlayerCard($board,1,"hand"));


        dump($boardService->getPlayerCard($board,1,"all"));

        dump($boardService->getPlayerCard($board,1,"hand"));

        $boardService->takePickaxe($board,1);
        dump($boardService->getPlayerCard($board,1,"hand"));

        dump($boardService->getPlayerCard($board,1,"rest_down"));

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers,$encoders);

        $data = $serializer->serialize($current_board,'xml');

        $game = new Game();
        $game->setBoard($data);
        $dt = new \DateTime();
        $dt->format('Y-m-d H:i:s');
        $game->setDateIn($dt);
        $game->setState(false);

        $em = $this->getDoctrine()->getManager();

        $em->persist($game);
        $em->flush();
        */




        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'data' => $data
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
