<?php

/**
 * Token authentication using JWT (Json Web Tokens), with configuration of public routes and routes that require authentication.
 *
 * @author Enzo Nagata <enzo.nagata@gmail.com>
 * @link      https://fb.com/enzomassaharunagata
 * @version     0.0.1
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controllers;

use App\AppController;
use Slim\Http\Request;
use Slim\Http\Response;

use App\Models\News;
use App\Models\Agenda;

class ApiController extends AppController
{


    public function __construct($container)
    {
        parent::__construct($container);
    }

    public function news(Request $req, Response $res)
    {
        $json = News::get();
        return $res->withStatus(200)->withJson($json);
    }

    public function agenda(Request $req, Response $res)
    {
        $json = Agenda::get();
        return $res->withStatus(200)->withJson($json);
    }
}
