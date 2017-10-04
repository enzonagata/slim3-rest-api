<?php
/**
 * Token authentication using JWT (Json Web Tokens), with configuration of public routes and routes that require authentication.
 *
 * @author Enzo Nagata <enzo.nagata@gmail.com>
 * @link      https://fb.com/enzomassaharunagata
 * @version     0.0.1
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

require __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/config/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/config/dependencies.php';

// Register middleware
require __DIR__ . '/config/middleware.php';

// Register routes
require __DIR__ . '/config/routes.php';

// Run app
$app->run();
