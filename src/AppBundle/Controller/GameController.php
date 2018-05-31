<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Game;
use AppBundle\Model\CarteModel;
use AppBundle\Service\BoardService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GameController extends Controller
{
    /**
     * @Route("/getBoard")
     */
    public function getBoardAction()
    {

        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('AppBundle:Game')->find(8);
        $data = $game->getBoard();

        $user = $this->getUser();
        dump($user->getUserName());
        dump($user->getId());

        $serializer = new Serializer(
            array(new GetSetMethodNormalizer(), new ArrayDenormalizer(), new ObjectNormalizer()),
            array(new XmlEncoder(), new JsonEncoder())
        );

        $current_board = $serializer->deserialize($data, CarteModel::class . '[]' , 'json');
        dump($current_board);

        dump($current_board);
        return $this->render('Game/get_board.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'data' => $data,
            'current_board' => $current_board
        ]);
    }

    

    /**
     * @Route("/sendBoard")
     */
    public function sendBoardAction()
    {
        // replace this example code with whatever you need
        $board = new BoardService();
        $current_board = $board->initialiseBoard($board->createBoard(),4);
        $board->takePickaxe($current_board,1);


       // dump($board->getPlayerCard($current_board,1,"all"));
      //  dump($board->getPlayerCard($current_board,1,"hand"));
       // dump($board->getPlayerCard($current_board,1,"rest_down"));
        //dump($board->getPlayerCard($current_board,1,"rest_up"));

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers,$encoders);

        $data = $serializer->serialize($current_board,'json');

        $game = new Game();
        $game->setBoard($data);
        $dt = new \DateTime();
        $dt->format('Y-m-d H:i:s');
        $game->setDateIn($dt);
        $game->setState(false);

        $em = $this->getDoctrine()->getManager();

        $em->persist($game);
        $em->flush();

        return $this->render('Game/send_board.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'data' => $data
        ]);
    }

}
