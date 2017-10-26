<?php 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Schema\Table;

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

//include Bundles
require __DIR__."/../src/UsersBundle/Resources/config/route.php";
require __DIR__."/../src/MemberBundle/Resources/config/route.php";

$app->get("/",function() use ($app){
    return new Response("index");
});

