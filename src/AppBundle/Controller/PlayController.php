<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Model\CarteModel;
use AppBundle\Service\BoardService;
use Proxies\__CG__\AppBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/lobby")
 */
class PlayController extends Controller
{
    /**
     * @Route("/search")
     */
    public function searchAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userid = $this->getUser()->getId();
        $user = $em->getRepository('AppBundle:User')->find($userid);

        $indice = 1;


        if ($user->isWantPlay() == false && $user->getInGame() == null) {
            $gameList = $em->getRepository('AppBundle:Game')->findBy(
                array('state' => 0)
            );
            dump($gameList);
            if ($gameList == null) {
                $board = new BoardService();
                $current_board = $board->createBoard();
                $encoders = array(new XmlEncoder(), new JsonEncoder());
                $normalizers = array(new ObjectNormalizer());

                $serializer = new Serializer($normalizers, $encoders);

                $data = $serializer->serialize($current_board, 'json');

                $game = new Game();
                $game->setBoard($data);
                $dt = new \DateTime();
                $dt->format('Y-m-d H:i:s');
                $game->setDateIn($dt);
                $game->setState(false);
                $game->setTourJoueur(0);

                $em2 = $this->getDoctrine()->getManager();

                $em2->persist($game);
                $em2->flush();


            }
            $gameList = $em->getRepository('AppBundle:Game')->findBy(
                array('state' => 0)
            );
            $user->setInGame($gameList[0]);
            $user->setWantPlay(true);
            $user->setIdInGame($gameList[0]->getNbJoueurs() + 1);
            $gameList[0]->setNbJoueurs($gameList[0]->getNbJoueurs() + 1);
            if ($gameList[0]->getNbJoueurs() == 4) {
                $gameList[0]->setState(1);


            }


            $em->persist($user);
            $em->flush();

        }
        return $this->render('play/create.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/start")
     */
    public function startAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if ($user->isWantPlay() == true) {
            $gameid = $user->getInGame()->getId();

            $game = $em->getRepository("AppBundle:Game")->find($gameid);
            if ($game->getNbJoueurs() > 1) {
                $game->setState(1);
                $boardService = new BoardService();
                $data = $game->getBoard();

                $serializer = new Serializer(
                    array(new GetSetMethodNormalizer(), new ArrayDenormalizer(), new ObjectNormalizer()),
                    array(new XmlEncoder(), new JsonEncoder())
                );

                $board = $serializer->deserialize($data, CarteModel::class . '[]', 'json');

                $gameboard = $boardService->initialiseBoard($board,$game->getNbJoueurs());

                $data2 = $serializer->serialize($gameboard, 'json');
                $game->setBoard($data2);
                $game->setTourJoueur(1);

                $em->persist($game);
                $em->flush();

                $userList = $em->getRepository('AppBundle:User')->findBy(
                    array('in_game' => $game)
                );
                foreach ($userList as $usertemp) {
                    $usertemp->setWantPlay(0);
                    $em->persist($usertemp);
                    $em->flush();
                }


            }
        }
        return $this->render('play/create.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
        /*
                if ($user->isWantPlay() == true) {
                    $userList = $em->getRepository('AppBundle:User')->findBy(
                        array('in_game' => $user->getInGame())
                    );

                    $indice = 0;
                    $nameList[0] = "";
                    foreach ($userList as $usertemp) {
                        $nameList[$indice] = $usertemp->getUsername();
                        $indice = +1;
                    }
                    return $this->render('play/lobby.html.twig', [
                        'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
                        'nameList' => $nameList
                    ]);

                } else {
                    $nameList[0] = "Vous ne voulez pas jouer";
                    return $this->render('play/lobby.html.twig', [
                        'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
                        'nameList' => $nameList
                    ]);
                }*/


    }

    /**
     * @Route("/kill", name="kill")
     */
    public function endAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userid = $this->getUser()->getId();
        $user = $em->getRepository('AppBundle:User')->find($userid);
        $userList = $em->getRepository('AppBundle:User')->findBy(
            array('in_game' => $user->getInGame())
        );

        $em3 = $this->getDoctrine()->getManager();
        $gametemp = $em3->getRepository('AppBundle:Game')->find($user->getInGame()->getId());
        $gametemp->setState(2);
        $em3->persist($gametemp);
        $em3->flush();

        foreach ($userList as $useringame) {
            $useringame->setInGame(null);
            $useringame->setWantPlay(0);
            $useringame->setIdInGame(null);

            $em->persist($useringame);
            $em->flush();
        }

        $user->setInGame(null);

        $em->flush();

        return $this->render('default/index.html.twig');

    }
}
