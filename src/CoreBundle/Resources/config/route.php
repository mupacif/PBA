<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


use \CoreBundle\Repository\DemandeRepository;
require __DIR__."/dev.php";

$app->get('/'.$bundleName."/test",function() use ($app,$bundleName){

    return new Response($bundleName." is set");
});