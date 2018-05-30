<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/game", name="game")
     */
    public function testAction(Request $request)
    {
        $jsonData = "[{\"id\":0,\"image\":\"2C.png\",\"color\":\"hide\",\"state\":\"rest_down\",\"player\":2,\"number\":\"hide\"},{\"id\":1,\"image\":\"3C.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":2,\"image\":\"4C.png\",\"color\":\"hide\",\"state\":\"rest_down\",\"player\":4,\"number\":\"hide\"},{\"id\":3,\"image\":\"5C.png\",\"color\":\"trefle\",\"state\":\"rest_up\",\"player\":2,\"number\":5},{\"id\":4,\"image\":\"6C.png\",\"color\":\"trefle\",\"state\":\"rest_up\",\"player\":4,\"number\":6},{\"id\":5,\"image\":\"7C.png\",\"color\":\"trefle\",\"state\":\"rest_up\",\"player\":1,\"number\":7},{\"id\":6,\"image\":\"8C.png\",\"color\":\"hide\",\"state\":\"rest_down\",\"player\":2,\"number\":\"hide\"},{\"id\":7,\"image\":\"9C.png\",\"color\":\"trefle\",\"state\":\"rest_down\",\"player\":1,\"number\":9},{\"id\":8,\"image\":\"10C.png\",\"color\":\"trefle\",\"state\":\"rest_up\",\"player\":4,\"number\":10},{\"id\":9,\"image\":\"11C.png\",\"color\":\"trefle\",\"state\":\"rest_up\",\"player\":4,\"number\":11},{\"id\":10,\"image\":\"12C.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":11,\"image\":\"13C.png\",\"color\":\"trefle\",\"state\":\"hand\",\"player\":1,\"number\":13},{\"id\":12,\"image\":\"14C.png\",\"color\":\"trefle\",\"state\":\"rest_down\",\"player\":1,\"number\":14},{\"id\":13,\"image\":\"2S.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":14,\"image\":\"3S.png\",\"color\":\"pique\",\"state\":\"rest_up\",\"player\":2,\"number\":3},{\"id\":15,\"image\":\"4S.png\",\"color\":\"hide\",\"state\":\"hand\",\"player\":2,\"number\":\"hide\"},{\"id\":16,\"image\":\"5S.png\",\"color\":\"hide\",\"state\":\"hand\",\"player\":3,\"number\":\"hide\"},{\"id\":17,\"image\":\"6S.png\",\"color\":\"pique\",\"state\":\"rest_up\",\"player\":1,\"number\":6},{\"id\":18,\"image\":\"7S.png\",\"color\":\"hide\",\"state\":\"rest_down\",\"player\":4,\"number\":\"hide\"},{\"id\":19,\"image\":\"8S.png\",\"color\":\"hide\",\"state\":\"hand\",\"player\":4,\"number\":\"hide\"},{\"id\":20,\"image\":\"9S.png\",\"color\":\"pique\",\"state\":\"rest_up\",\"player\":3,\"number\":9},{\"id\":21,\"image\":\"10S.png\",\"color\":\"hide\",\"state\":\"rest_down\",\"player\":2,\"number\":\"hide\"},{\"id\":22,\"image\":\"11S.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":23,\"image\":\"12S.png\",\"color\":\"pique\",\"state\":\"rest_up\",\"player\":2,\"number\":12},{\"id\":24,\"image\":\"13S.png\",\"color\":\"hide\",\"state\":\"rest_down\",\"player\":4,\"number\":\"hide\"},{\"id\":25,\"image\":\"14S.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":26,\"image\":\"2D.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":27,\"image\":\"3D.png\",\"color\":\"hide\",\"state\":\"hand\",\"player\":3,\"number\":\"hide\"},{\"id\":28,\"image\":\"4D.png\",\"color\":\"hide\",\"state\":\"rest_down\",\"player\":3,\"number\":\"hide\"},{\"id\":29,\"image\":\"5D.png\",\"color\":\"hide\",\"state\":\"hand\",\"player\":4,\"number\":\"hide\"},{\"id\":30,\"image\":\"6D.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":31,\"image\":\"7D.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":32,\"image\":\"8D.png\",\"color\":\"carreau\",\"state\":\"hand\",\"player\":1,\"number\":8},{\"id\":33,\"image\":\"9D.png\",\"color\":\"hide\",\"state\":\"hand\",\"player\":3,\"number\":\"hide\"},{\"id\":34,\"image\":\"10D.png\",\"color\":\"carreau\",\"state\":\"rest_down\",\"player\":1,\"number\":10},{\"id\":35,\"image\":\"11D.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":36,\"image\":\"12D.png\",\"color\":\"carreau\",\"state\":\"rest_up\",\"player\":3,\"number\":12},{\"id\":37,\"image\":\"13D.png\",\"color\":\"hide\",\"state\":\"hand\",\"player\":4,\"number\":\"hide\"},{\"id\":38,\"image\":\"14D.png\",\"color\":\"hide\",\"state\":\"hand\",\"player\":2,\"number\":\"hide\"},{\"id\":39,\"image\":\"2H.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":40,\"image\":\"3H.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":41,\"image\":\"4H.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":42,\"image\":\"5H.png\",\"color\":\"coeur\",\"state\":\"rest_up\",\"player\":1,\"number\":5},{\"id\":43,\"image\":\"6H.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"},{\"id\":44,\"image\":\"7H.png\",\"color\":\"hide\",\"state\":\"rest_down\",\"player\":3,\"number\":\"hide\"},{\"id\":45,\"image\":\"8H.png\",\"color\":\"coeur\",\"state\":\"hand\",\"player\":1,\"number\":8},{\"id\":46,\"image\":\"9H.png\",\"color\":\"coeur\",\"state\":\"current_card\",\"player\":0,\"number\":9},{\"id\":47,\"image\":\"10H.png\",\"color\":\"coeur\",\"state\":\"hand\",\"player\":1,\"number\":10},{\"id\":48,\"image\":\"11H.png\",\"color\":\"hide\",\"state\":\"rest_down\",\"player\":3,\"number\":\"hide\"},{\"id\":49,\"image\":\"12H.png\",\"color\":\"coeur\",\"state\":\"rest_up\",\"player\":3,\"number\":12},{\"id\":50,\"image\":\"13H.png\",\"color\":\"hide\",\"state\":\"hand\",\"player\":2,\"number\":\"hide\"},{\"id\":51,\"image\":\"14H.png\",\"color\":\"hide\",\"state\":\"pickaxe\",\"player\":0,\"number\":\"hide\"}]";

        if ($request->isXmlHttpRequest() || $request->request->get('id_card')) {
            return new JsonResponse($jsonData);
        }
        return $this->render('default/game.html.twig');
    }
}
