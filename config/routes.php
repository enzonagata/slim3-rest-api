<?php
/**
 * Token authentication using JWT (Json Web Tokens), with configuration of public routes and routes that require authentication.
 *
 * @author Enzo Nagata <enzo.nagata@gmail.com>
 * @link      https://fb.com/enzomassaharunagata
 * @version     0.0.1
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */


$app->post('/api/token', 'App\Controllers\UsersController:token');

$app->post('/api/user', 'App\Controllers\UsersController:user'); //User Insert
$app->put('/api/user', 'App\Controllers\UsersController:user'); //User update

