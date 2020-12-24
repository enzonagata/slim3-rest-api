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
use Illuminate\Database\Eloquent\Model;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Users;
use Firebase\JWT\JWT;

class ApiController extends AppController
{


    public function __construct($container)
    {
        parent::__construct($container);
    }

    public function news(Request $req, Response $res)
    {

        $json = [

            [
                'news_id' => '1',
                'news_title'  => 'Teste',
                'news_content' => 'Generated content'
            ]
        ];

        return $res->withStatus(200)->withJson($json);
    }

    public function agenda(Request $req, Response $res)
    {

        $json = [

            [
                'news_id' => '1',
                'news_title'  => 'Teste',
                'news_content' => 'Generated content'
            ]
        ];

        return $res->withStatus(200)->withJson($json);
    }
}
