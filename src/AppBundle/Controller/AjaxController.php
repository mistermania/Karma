<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Model\CarteModel;
use AppBundle\Service\BoardService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/ajax")
 */
class AjaxController extends Controller
{
    /**
     * @Route("/", name="app_ajax")
     */
    public function indexAction(Request $request)
    {
        //recupère le tableau en bdd


        $board = $this->getBoardBDD();

        dump($board);

        $boardService = new BoardService();


        $user = $this->getUser();
        dump($user->getUserName());
        dump($user->getId());


        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $current_player = $user->getInGame()->getTourJoueur();


        $header = array('nb_player' => $user->getInGame()->getNbJoueurs(),
            'current_player' => $current_player,
            'id_player' => $user->getIdInGame(),
            'nb_hand_card' => $boardService->getPlayerCard($board, $user->getIdInGame(), "hand"));


        $clean_data = $boardService->cleanSendBoard($board, $user->getIdInGame());

        $json_array = array('header' => $header, 'board' => $clean_data);
        dump($json_array);
        $json_clean_data = $serializer->serialize($json_array, 'json');
        dump($json_clean_data);
        if ($request->isXmlHttpRequest()) {

            return new JsonResponse($json_clean_data);

        }

        return $this->render('Game/get_board.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'data' => $json_clean_data
        ]);
    }


    /**
     * @Route("/take_played_card", name="app_ajax_pickaxe")
     */
    public function takePlayedCard(Request $request)
    {
        //recupère le tableau en bdd

        $board = $this->getBoardBDD();

        dump($board);

        $boardService = new BoardService();


        $user = $this->getUser();

        $boardService->takePlayedCard($board, $user->getIdInGame());
        $this->passeTourBDD($user->getInGame()->getNbJoueurs());

        $this->addBoardBDD($board);


        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);





        $current_player = $user->getInGame()->getTourJoueur();
        $header = array('nb_player' => $user->getInGame()->getNbJoueurs(),
            'current_player' => $current_player,
            'id_player' => $user->getIdInGame(),
            'nb_hand_card' => $boardService->getPlayerCard($board, $user->getIdInGame(), "hand"));


        $clean_data = $boardService->cleanSendBoard($board, $user->getIdInGame());

        $json_array = array('header' => $header, 'board' => $clean_data);
        dump($json_array);
        $json_clean_data = $serializer->serialize($json_array, 'json');


        if ($request->isXmlHttpRequest()) {

            return new JsonResponse($json_clean_data);

        }

        return $this->render('Game/get_board.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'data' => $json_clean_data
        ]);
    }

    /**
     * @Route("/move_card", name="app_ajax_move")
     */
    public function moveCard(Request $request)
    {
        //recupère le tableau en bdd

        $board = $this->getBoardBDD();

        //dump($board);

        $boardService = new BoardService();

        $user = $this->getUser();

        if ($request->request->get('id_card')) {

            $userTest = ($user->getInGame()->getTourJoueur() % $user->getInGame()->getNbJoueurs() )+ 1 ;
            dump($user->getIdInGame());
            dump($userTest);
            $current_player = ($user->getInGame()->getTourJoueur() % $user->getInGame()->getNbJoueurs() )+ 1;
            if ($user->getIdInGame() == $user->getInGame()->getTourJoueur()) {

                $id_card = $request->request->get("id_card");


                if ($board[$id_card]->getPlayer() == $user->getIdInGame()) {


                    if ($boardService->moveCard($board, $board[$id_card])) {

                        if ($board[$id_card]->getNumber() == 10) {
                            $boardService->putInBin($board);
                        }else{
                            $this->passeTourBDD($user->getInGame()->getNbJoueurs());

                        }

                        if ($boardService->getPlayerCard($board, $user->getIdInGame(), "hand") < 3) {
                            $boardService->takePickaxe($board, $user->getIdInGame());

                        }


                        $this->addBoardBDD($board);


                        $encoders = [new JsonEncoder()];
                        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
                        $serializer = new Serializer($normalizers, $encoders);





                        $header = array('nb_player' => $user->getInGame()->getNbJoueurs(),
                            'current_player' => $current_player,
                            'id_player' => $user->getIdInGame(),
                            'nb_hand_card' => $boardService->getPlayerCard($board, $user->getIdInGame(), "hand"));


                        $clean_data = $boardService->cleanSendBoard($board, $user->getIdInGame());

                        $json_array = array('header' => $header, 'board' => $clean_data);
                        dump($json_array);
                        $json_clean_data = $serializer->serialize($json_array, 'json');



                        if ($request->isXmlHttpRequest()) {

                            return new JsonResponse($json_clean_data);

                        }
                    } else {
                        $json_erreur = array('erreur' => "Le deplacement n'est pas possible ");

                        $json_clean_data = json_encode($json_erreur);
                        return new JsonResponse($json_clean_data);
                    }


                } else {
                    $json_erreur = array('erreur' => "La carte n'appartient pas au joueur");

                    $json_clean_data = json_encode($json_erreur);
                    return new JsonResponse($json_clean_data);
                }
            } else {
                $json_erreur = array('erreur' => "Joueur Incorrect");

                $json_clean_data = json_encode($json_erreur);
                return new JsonResponse($json_clean_data);
            }
        } else {
            $json_erreur = array('erreur' => "URL incorrect");

            $json_clean_data = json_encode($json_erreur);
            return new JsonResponse($json_clean_data);
        }


        return $this->render('Game/get_board.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'data' => $json_clean_data
        ]);
    }


    private
    function getBoardBDD()
    {
        $em = $this->getDoctrine()->getManager();
        // $game = $em->getRepository('AppBundle:Game')->findOneBy([],['id' => 'DESC'],1);
        //  $data = $game->getBoard();
        $user = $this->getUser();
        $game = $em->getRepository('AppBundle:Game')->find($user->getInGame()->getId());
        $data = $game->getBoard();

        $serializer = new Serializer(
            array(new GetSetMethodNormalizer(), new ArrayDenormalizer(), new ObjectNormalizer()),
            array(new XmlEncoder(), new JsonEncoder())
        );

        $board = $serializer->deserialize($data, CarteModel::class . '[]', 'json');

        return $board;
    }

    private
    function addBoardBDD($board)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($board, 'json');
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository("AppBundle:Game")->find($user->getInGame()->getId());
        $game->setBoard($data);

        $dt = new \DateTime();
        $dt->format('Y-m-d H:i:s');
        $game->setDateIn($dt);
        $game->setState(false);

        $em->flush();
    }

    private
    function passeTourBDD($nbJoueurs)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $game = $em->getRepository("AppBundle:Game")->find($user->getInGame()->getId());
        if ($game->getTourJoueur() == $nbJoueurs) $game->setTourJoueur(1);
        else $game->setTourJoueur(($game->getTourJoueur() + 1));

        $em->flush();
    }


}
