<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


use \UsersBundle\Repository\UserRepository;
require __DIR__."/dev.php";

$bundleName="User";

$app->get('/'.$bundleName."/test",function() use ($app,$bundleName){
     return new Response("Bundle::".$bundleName);
});

$app->get('/'.$bundleName."/install",function() use ($app){
	if($app['usersBundle.app']->install($app))
     return new Response("test success");
    else
     return new Response("test failed");
});



$app->get('/'.$bundleName."/signup",function() use ($app){
    return $app['twig']->render('UsersBundle/Resources/views/register.html.twig');
});

$app->get('/'.$bundleName."/login",function(Request $request) use ($app){
    return $app['twig']->render('UsersBundle/Resources/views/login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});


$app->post('/'.$bundleName."/signup",function(Request $request) use ($app){

    $username = $request->get('username');
    $email = $request->get('email');
    $password = $request->get('password');
    $password_confirm = $request->get('password_confirm');
    $name = $request->get('name');
    $surname = $request->get('surname');
    $phone = $request->get('phone');


        $data = array(
            UserRepository::$USERNAME => $username,
            UserRepository::$PASSWORD => $password,
            'password_confirm' => $password_confirm,
            UserRepository::$NAME => $name,
            UserRepository::$SURNAME => $surname,
            UserRepository::$PHONE => $phone,
            UserRepository::$EMAIL => $email);

        $constraint = new Assert\Collection(array(
            UserRepository::$USERNAME => new Assert\Length(array('min' => 5)),
            UserRepository::$PASSWORD => new Assert\Length(array('min' => 6)),
                'password_confirm' => new Assert\EqualTo($password_confirm),
            UserRepository::$NAME => new Assert\Length(array('min' => 2)),
            UserRepository::$SURNAME => new Assert\Length(array('min' => 2)),
            UserRepository::$PHONE => new Assert\NotBlank(),
            UserRepository::$EMAIL => new Assert\Email(),
          )
        );
        $errors = $app['validator']->validate($data, $constraint);


        if (count($errors) > 0) {

            return $app->json((String)$errors);
        }else{
            $app['db']->insert(UserRepository::$TABLEUSER,
                array(
                    UserRepository::$USERNAME => $username,
                    UserRepository::$PASSWORD => $app['security.default_encoder']->encodePassword($password, ''),
                    UserRepository::$NAME => $name,
                    UserRepository::$SURNAME => $surname,
                    UserRepository::$PHONE => $phone,
                    UserRepository::$EMAIL => $email,
                    UserRepository::$ROLES => 'ROLE_USER',
                    UserRepository::$DATE => (new \DateTime())->format(DateTime::ISO8601),
                )
            );
            $message = \Swift_Message::newInstance()
                ->setSubject('Your subscribe')
                ->setFrom(array('noreply@pacee.net'))
                ->setTo(array($email))
                ->setBody("helle $name , you can connect with your username:$username");
            $app['mailer']->send($message);


            return $app->json(0);
        }
})->bind("post_signup");