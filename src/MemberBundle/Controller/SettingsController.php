<?php

namespace MemberBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \UsersBundle\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use \Silex\Application;

class SettingsController
{

    public function setPassportAction(Request $request,$app)
    {
        $password = $request->get("password");
        $errors = $app['validator']->validate($password, new Assert\Length(array('min' => 6)));
        if (count($errors) > 0) {
            $app->json(-1);
        }
        else{

            $token = $app['security.token_storage']->getToken();
            if (null !== $token) {
                $user =  $token->getUser();
            }

            $ok = $app['db']->executeUpdate("UPDATE ".UserRepository::$TABLEUSER." SET ".UserRepository::$PASSWORD." = ? WHERE ".UserRepository::$ID." = ?",
                array($app['security.default_encoder']->encodePassword($password,''), $user->getId()));

            $app->json(1);
        }
    }

    public function setNameAction(Request $request,$app)
    {
        $json = $this->setting($request,$app,UserRepository::$NAME,new Assert\Length(array('min' => 2)));
        return $app->json($json);
    }

    public function setSurnameAction(Request $request,$app)
    {
        $json = $this->setting($request,$app,UserRepository::$SURNAME,new Assert\Length(array('min' => 2)));
        return $app->json($json);
    }

    public function setPhoneAction(Request $request,$app)
    {
        $json = $this->setting($request,$app,UserRepository::$PHONE,new Assert\NotBlank());
        return $app->json($json);
    }

    public function setEmailAction(Request $request,$app)
    {
        $json = $this->setting($request,$app,UserRepository::$EMAIL,new Assert\Email());
        return $app->json($json);
    }

    function setting(Request $request,$app,$key,$assertion)
    {
        $value = $request->get($key);
        $errors = $app['validator']->validate($value, $assertion);
        if (count($errors) > 0) {
            return $app->json(-1);
        }
        else{

            $token = $app['security.token_storage']->getToken();
            if (null !== $token) {
                $user =  $token->getUser();
            }

            $ok = $app['db']->executeUpdate("UPDATE ".UserRepository::$TABLEUSER." SET ".$key." = ? WHERE ".UserRepository::$ID." = ?",
                array($value, $user->getId()));

            return $app->json(1);
        }
    }
}