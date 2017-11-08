<?php
namespace CoreBundle\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \DateTime;
use CoreBundle\Repository\DemandeRepository;

class DemandesController
{

    public function addDemandePageController(Request $request,Application $app)
    {
        return $app['twig']->render("views/alpha/core/demande.html.twig");
    }
    public function addDemandesController(Request $request,Application $app)
    {
        $description = $request->get('description');
        $poids = $request->get('poids');
        $token = $app['security.token_storage']->getToken();
        if (null !== $token && ($user = $token->getUser()) !== "anon." ) {
            $userId = $user->getId();
            $date = (new \DateTime())->format(DateTime::ISO8601);
            $app['db']->insert(DemandeRepository::$TABLENAME,array(DemandeRepository::$DESCRIPTION=>$description,
                DemandeRepository::$POIDS=>$poids,
                DemandeRepository::$DATE=>$date,
                DemandeRepository::$USERID=>$userId
//                DemandeRepository::$ACCEPTED=>false
            ));
            return true;
        }
        else
            return false;

    }
    public function testAction()
    {
        return new Response("test succeful");
    }
}