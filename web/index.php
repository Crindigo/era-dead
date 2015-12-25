<?php
use josegonzalez\Dotenv\Loader as Dotenv;
use Radar\Adr\Boot;
use Relay\Middleware\ExceptionHandler;
use Relay\Middleware\ResponseSender;
use Zend\Diactoros\Response as Response;
use Zend\Diactoros\ServerRequestFactory as ServerRequestFactory;

define('ERA_ROOT', dirname(__DIR__));

/**
 * Bootstrapping
 */
require '../vendor/autoload.php';

Dotenv::load([
    'filepath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env',
    'toEnv' => true,
]);

$boot = new Boot();
$adr = $boot->adr([
    'Era\Boot\ContainerSetup',
]);

/**
 * Middleware
 */
$adr->middle(new ResponseSender());
$adr->middle(new ExceptionHandler(new Response()));
$adr->middle('Radar\Adr\Handler\RoutingHandler');
$adr->middle('Radar\Adr\Handler\ActionHandler');

$adr->input('Era\Http\Input\EraInput');
$adr->responder('Era\Http\Responder\TwigResponder');

/**
 * Routes
 */
$adr->get('Era\Home\Index', '/', 'Era\Domain\Home\AppService\Home');

/**
 * Run
 */
$adr->run(ServerRequestFactory::fromGlobals(), new Response());
