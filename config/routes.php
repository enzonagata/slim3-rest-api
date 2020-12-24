<?php
/**
 * Token authentication using JWT (Json Web Tokens), with configuration of public routes and routes that require authentication.
 *
 * @author Enzo Nagata <enzo.nagata@gmail.com>
 * @link      https://fb.com/enzomassaharunagata
 * @version     0.0.1
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */


$app->post('/token', 'App\Controllers\UsersController:token');

$app->post('/user/create', 'App\Controllers\UsersController:user'); //User Insert
$app->put('/user/create', 'App\Controllers\UsersController:user'); //User update


$app->get('/', 'App\Controllers\UsersController:index');

$app->get('/news', 'App\Controllers\ApiController:news');
$app->get('/agenda', 'App\Controllers\ApiController:agenda');

