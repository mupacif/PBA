<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


use \CoreBundle\Repository\DemandeRepository;
require __DIR__."/dev.php";

$app->get('/'.$bundleName."/",function() use ($app){
    $token = $app['security.token_storage']->getToken();
    if (null !== $token) {
        $user =  $token->getUser();
    }
    return new Response("index");
});