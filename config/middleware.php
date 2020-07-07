<?php
// FIFO
return function (\Slim\App $app):void {
    // optional sub directory
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();
    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();
    $app->add(\App\Middleware\NotFoundMiddleware::class);
    $app->add(\App\Middleware\DatabaseMiddleware::class);
    // Catch exceptions and errors
    $app->add(\Slim\Middleware\ErrorMiddleware::class);
    // Add Twig-View Middleware
    $app->add(\Slim\Views\TwigMiddleware::class);
};
