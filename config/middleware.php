<?php

use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Psr\Container\ContainerInterface;
use Slim\Views\TwigMiddleware;
use Slim\Views\Twig;

return function (App $app, ContainerInterface $container) {
    // optional sub directory
    //$app->setBasePath('/sim');
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();
    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();
    // Catch exceptions and errors
    $app->add(ErrorMiddleware::class);
    // Add Twig-View Middleware
    $app->add(TwigMiddleware::create($app, $container->get(Twig::class)));
};
