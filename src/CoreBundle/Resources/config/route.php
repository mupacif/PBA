<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;



use \CoreBundle\Repository\DemandeRepository;
require __DIR__."/dev.php";

$app->get('/'.$bundleName."/test",function() use ($app,$bundleName){

    return new Response($bundleName." is set");
});

$app->post('/'.$bundleName."/demande",function(Request $request) use($app)
    {
        $description = $request->get('description');
        $poids = $request->get('poids');
        $token = $app['security.token_storage']->getToken();
        if (null !== $token) {
            $user = $token->getUser();


        $userId = $user->getId();
        $date = (new \DateTime())->format(DateTime::ISO8601);
        $app['db']->insert(DemandeRepository::$TABLENAME,array(DemandeRepository::$DESCRIPTION=>$description,
            DemandeRepository::$POIDS=>$poids,
            DemandeRepository::$DATE=>$date,
            DemandeRepository::$USERID=>$userId,
            DemandeRepository::$ACCEPTED=>false
        ));
        return true;
         }
         else
             return false;
    }
);