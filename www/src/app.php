<?php
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

$app->register(new FormServiceProvider());
$app->register(new LocaleServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));
$app->register(new TwigServiceProvider(), array(
    'twig.path' => array(__DIR__.'/views')
));
$app->register(new ValidatorServiceProvider());

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'dbname'   => 'test-db',
        'host'     => 'db',
        'user'     => 'test-db',
        'password' => 'test-db',
        'port'     => '3306'
    ),
));

$app['upload_path'] = '/data/upload';
$app['debug'] = true;

return $app;
