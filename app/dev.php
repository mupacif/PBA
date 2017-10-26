<?php

$app['dbs.options'] = array(
    'sqlite' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/../db/sqlite.db',
        ),
    );

