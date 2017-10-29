<?php

$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app['swiftmailer.options'] = array(
    'host' => 'ssl0.ovh.net',
    'port' => 465,
    'username' => 'postmaster@pacee.net',
    'password' => 'rrmxVdxN',
    'encryption' => 'ssl',
    'auth_mode' => 'login'
);


$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\DoctrineServiceProvider());


$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src',
));

$app['security.default_encoder'] = function ($app) {
    return $app['security.encoder.bcrypt'];
};

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));


$app->register(new Silex\Provider\SessionServiceProvider());
/**
 * Security
 */
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'PiggyBeeAfro' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new UsersBundle\Repository\UserRepository($app['dbs']['sqlite']);
            },
            'logout' => array('logout_path' => '/logout', 'invalidate_session' => true),
        ),
    ),
));

$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER'),
);

$app['security.access_rules'] = array(
    array('^/member/.*$', 'ROLE_USER'),
    array('^/member$', 'ROLE_USER'),
);
