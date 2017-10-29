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



$skin ="alpha";

/*
$app->get("/",function() use ($app){
    return new Response("index");
});
*/


$app->get("/",function() use ($app,$skin){

    $token = $app['security.token_storage']->getToken();
    if (null !== $token && ($user =  $token->getUser()) && !empty($user->getSurname())) {
        

        return $app->redirect($app["url_generator"]->generate("member"));
    }
    return $app['twig']->render('views/'.$skin.'/index.html.twig');
})->bind('index');


$app->get("/login",function(Request $request) use ($app,$skin){
     return $app['twig']->render('views/'.$skin.'/signin.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('signin');

$app->get("/signup",function() use ($app,$skin){
/*        $token = $app['security.token_storage']->getToken();
    if (null !== $token) {
        $user =  $token->getUser();
        return $app->redirect($app["url_generator"]->generate("member"));
    }*/
     return $app['twig']->render('views/'.$skin.'/signup.html.twig');
})->bind('signup');;


$app->get("/member",function() use ($app,$skin){
     return $app['twig']->render('views/'.$skin.'/member.html.twig');
})->bind('member');;



$app->get("/member/settings",function() use ($app,$skin){
        $token = $app['security.token_storage']->getToken();
    if (null !== $token) {
        $user =  $token->getUser();
    }
     return $app['twig']->render('views/'.$skin.'/member/settings.html.twig',array('user'=>$user));
})->bind('member_settings');


//include Bundles
require __DIR__."/../src/UsersBundle/Resources/config/route.php";
require __DIR__."/../src/MemberBundle/Resources/config/route.php";