<?php

$app['usersBundle.user'] = function ($app) {
    return new UsersBundle\Repository\UserRepository($app['dbs']['sqlite']);
};

$app['usersBundle.app'] = function($app){
    return new UsersBundle\Controller\DefaultController($app['dbs']['sqlite']);
};