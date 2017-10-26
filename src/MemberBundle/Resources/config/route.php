<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


use \UsersBundle\Repository\UserRepository;
require __DIR__."/dev.php";

$bundleName="member";

$app->get('/'.$bundleName."/",function() use ($app){
    $token = $app['security.token_storage']->getToken();
    if (null !== $token) {
        $user =  $token->getUser();
    }
    return $app['twig']->render('MemberBundle/Resources/views/index.html.twig',array('msg'=>$user));
});

$app->get('/'.$bundleName."/settings",function() use ($app){
    $app->abort(404, "Post does not exist.");
    return new Response("hello");
});

//Settings

$app->post('/'.$bundleName."/setPassword","MemberBundle\Controller\SettingsController::setPassportAction");

$app->post('/'.$bundleName."/setName","MemberBundle\Controller\SettingsController::setNameAction");

$app->post('/'.$bundleName."/setSurname","MemberBundle\Controller\SettingsController::setSurnameAction");

$app->post('/'.$bundleName."/setPhone","MemberBundle\Controller\SettingsController::setPhoneAction");

$app->post('/'.$bundleName."/setEmail","MemberBundle\Controller\SettingsController::setEmailAction");



