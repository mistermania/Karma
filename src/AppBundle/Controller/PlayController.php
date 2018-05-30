<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Service\BoardService;
use Proxies\__CG__\AppBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PlayController extends Controller
{
    /**
     * @Route("/create")
     */
    public function createAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userid = $this->getUser()->getId();
        $user = $em->getRepository('AppBundle:User')->find($userid);

        $indice = 1;


        if($user->isWantPlay() == false && $user->getInGame() == null){
            while ($indice>0) {
                $user->setWantPlay(true);
                $game = $em->getRepository('AppBundle:Game')->find(100);
                if($game == null){
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

                    $em2 = $this->getDoctrine()->getManager();

                    $em2->persist($game);
                    $em2->flush();
                }
                $test = $em->getRepository('AppBundle:User')->findBy(
                    array('in_game' => $indice)
                );
                dump($test);
                if (count($test)<4 && count($test)>0){
                    if(($test[0])->isWantPlay() == true){
                        $user->setInGame($game);
                        $indice = 0;
                    }

                }
                else if(count($test) == 0){
                    $user->setInGame($game);
                    $indice=0;
                }
                else{
                    $indice =+ 1;
                }
            }
        }
        $em->persist($user);
        $em->flush();


        return $this->render('play/create.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("end")
     */
    public function endAction(){
        $em = $this->getDoctrine()->getManager();
        $userid = $this->getUser()->getId();
        $user = $em->getRepository('AppBundle:User')->find($userid);

        $user->setWantPlay(false);
        $user->setInGame(null);

        $em->flush();
        return $this->render('play/create.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);


    }

}