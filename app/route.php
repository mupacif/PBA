<?php 
use Symfony\Component\HttpFoundation\Request;


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

if ($app['security.authorization_checker']->isGranted('ROLE_USER'))
        return $app->redirect($app["url_generator"]->generate("member"));
else
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

$app->get("/member/demande","CoreBundle\Controller\DemandesController::addDemandePageController")->bind("member_demande");


$app->get("/member/settings",function() use ($app,$skin){
        $token = $app['security.token_storage']->getToken();
    if (null !== $token) {
        $user =  $token->getUser();
    }
     return $app['twig']->render('views/'.$skin.'/member/settings.html.twig',array('user'=>$user));
})->bind('member_settings');


$app->get("/member/users",function() use ($app,$skin){

    $users = $app['dao.users']-> findAllUsers();
    return $app['twig']->render('views/'.$skin.'/member/list.html.twig',array('users'=>$users));
/*return $app->json($users);*/
})->bind('admin_lists');


//include Bundles
require __DIR__."/../src/UsersBundle/Resources/config/route.php";
require __DIR__."/../src/MemberBundle/Resources/config/route.php";
require __DIR__."/../src/CoreBundle/Resources/config/route.php";