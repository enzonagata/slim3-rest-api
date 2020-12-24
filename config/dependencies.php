<?php
/**
 * Token authentication using JWT (Json Web Tokens), with configuration of public routes and routes that require authentication.
 *
 * @author Enzo Nagata <enzo.nagata@gmail.com>
 * @link      https://fb.com/enzomassaharunagata
 * @version     0.0.1
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// database
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

// Controller
$container['Controller'] = function ($c) {
    return new \App\Controller($c);
};

//Personal default error handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $data = [
            "status" => '404'
        ];
        return $c['response']
            ->withStatu(404)
            ->withJson($data);
    };
};

$c['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $data = [
            "status" => '500',
            "msg"=>"Ocorreu um erro interno"
        ];
        return $c['response']
            ->withStatus(405)
            ->withJson($data);
    };
};

//Personal not allowed handler
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        $data = [
            "status" => '405',
            "msg"=>"method not allowed"
        ];
        return $c['response']
            ->withStatus(405)
            ->withJson($data);
    };
};