<?php
/**
 * Token authentication using JWT (Json Web Tokens), with configuration of public routes and routes that require authentication.
 *
 * @author Enzo Nagata <enzo.nagata@gmail.com>
 * @link      https://fb.com/enzomassaharunagata
 * @version     0.0.1
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Users;
use Firebase\JWT\JWT;

function getBearerToken($token)
{
    // HEADER: Get the access token from the header
    if (!empty($token)) {
        if (preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

class TokenAuth
{
    private $container;
    private $public_paths;
    private $secret_key;

    public function __construct($container)
    {
        $this->container = $container;
        $this->public_paths = $this->container['settings']['public_paths'];
        $this->secret_key = $this->container['settings']['secret_key'];
    }

    public function __invoke(Request $req, Response $res, $next)
    {
        //Url_path requisitada
        $url_path = $req->getUri()->getPath();

        //Verifica se a URL é publica para consulta
        if (in_array($url_path, $this->public_paths)) {
            return $next($req, $res);
        } else {
            return $this->AuthToken($req, $res, $next);
        }

    }

    public function AuthToken($req, $res, $next)
    {
        //Pega token
        $tokenAuth = $req->getHeader('Authorization');
        $tokenAuth = getBearerToken($tokenAuth[0]);

        try {
            $decoded = JWT::decode($tokenAuth, $this->secret_key, array('HS256'));
            return $res->withStatus(200)->withJson($decoded);
        } catch (\Firebase\JWT\ExpiredException $e) {
            $json = [
                'code' => '401',
                'error' => $e
            ];
            return $res->withStatus(401)->withJson($json);
        }



    }

}