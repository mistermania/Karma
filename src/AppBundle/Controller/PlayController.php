<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

        $indice = 2;


        if($user->isWantPlay() == false && $user->getInGame() == null){
            while ($indice>0) {
                $user->setWantPlay(true);
                $test = $em->getRepository('AppBundle:User')->findBy(
                    array('in_game' => $indice)
                );
                if (count($test)<4 && count($test)>0){
                    if(($test[0])->isWantPlay() == true){
                        $user->setInGame($indice);
                    }

                }
                else if(count($test) == 0){
                    $user->setInGame($indice);
                }
                else{
                    $indice =+ 1;
                }
            }
        }


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

    }

}
