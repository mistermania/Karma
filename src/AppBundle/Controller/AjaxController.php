<?php

namespace AppBundle\Controller;

use AppBundle\Service\BoardService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
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

        $boardService = new BoardService();
        $board = $boardService->initialiseBoard($boardService->createBoard(),4);

        //Recuperation de l'utilisateur
        $id_user = 1;


        $encoders=[new JsonEncoder()];
        $normalizers=[new ObjectNormalizer(),new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers,$encoders);
        dump($serializer->serialize($board,'json'));


        //if($request->isXmlHttpRequest())
        if($request->request->get('playedCard')){

            $boardService->takePlayedCard($board,$id_user);

            return new JsonResponse($boardService->cleanSendBoard($board,$id_user));
        }


        //if($request->isXmlHttpRequest())
        if($request->request->get('move')){

            $id_card = $request->request->get('move');

            if($board[$id_card]->getPlayer() == $id_user) {

                $boardService->moveCard($board, $board[$id_card]);

                return new JsonResponse($boardService->cleanSendBoard($board, $id_user));
            }
        }

        return $this->render('default/index.html.twig');
    }
}
