<?php

use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
//use Slim\Views\PhpRenderer;
use Slim\Views\Twig;
//use Illuminate\Container\Container as IlluminateContainer;
//use Illuminate\Database\Connection;
//use Illuminate\Database\Connectors\ConnectionFactory;
use Psr\Container\ContainerInterface;
use Selective\Config\Configuration;

return [
    Configuration::class => function () {
        return new Configuration(require __DIR__ . '/settings.php');
    },
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        $app = AppFactory::create();   
        return $app;
    },
    Twig::class => function(ContainerInterface $container)
    {
        return Twig::create($container
            ->get(Configuration::class)
            ->getArray('templates'), [
                $container
                    ->get(Configuration::class)
                    ->getArray('cache')
            ]);
    },
    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container
            ->get(Configuration::class)
            ->getArray('error_handler_middleware');

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },
    //    PhpRenderer::class => function(ContainerInterface $container) {
    //        $templateVariables = [
    //            'app_name' => 'Slim Twig',
    //            'date' => date('Y'),
    //            'link' => array(
    //                'home' => '/home',
    //                'profile' => '/profile'
    //            ),
    //        ];
    //
    //        return new PhpRenderer('../templates', $templateVariables);
    //    },
    // Database connection
    //    Connection::class => function (ContainerInterface $container) {
    //        $factory = new ConnectionFactory(new IlluminateContainer());
    //
    //        $connection = $factory->make($container
    //                              ->get(Configuration::class)
    //                              ->getArray('db'));
    //
    //        // Disable the query log to prevent memory issues
    //        $connection->disableQueryLog();
    //
    //        return $connection;
    //    },
    //    PDO::class => function (ContainerInterface $container) {
    //        return $container->get(Connection::class)->getPdo();
    //    },
];
