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

class UsersController extends AppController
{

    protected $secret_key;

    public function __construct($container)
    {
        $this->secret_key = $container['settings']['secret_key'];
        parent::__construct($container);
    }

    /*
   * Gerar token de acesso
   * */
    public function token(Request $req, Response $res, $next)
    {
        $time = new \DateTime();
        $post = $req->getParams();
        $username = $post['username'];
        $password = $post['password'];

        $user = Users::where('username', $username)->first();

        //Senha gravada
        $db_password = $user->getAttribute('password');

        //Verificação da senha
        $password_verify = password_verify($password, $db_password);

        //Se a senha for válida
        if ($password_verify) {

            $token_options = array(
                "id_user" => $user->getAttribute('id'),
                "user" => $user->getAttribute('username'),
                "ini" => $time->getTimestamp(),
                "exp" => $time->modify("+1 day")->getTimestamp()
            );

            //Validação do token existente
            $token = $user->getAttribute('token');

            if ($token != "") {
                //Valida tempo de vida do token
                if ($this->token_validate($token, $this->secret_key)) {
                    $valid_token = $token;
                } else {
                    //Gerar token novo
                    $valid_token = JWT::encode($token_options, $this->secret_key);
                    //Atualiza token
                    Users::where('id', $user->getAttribute('id'))->update(['token' => $valid_token]);
                }
            } else {
                //Gerar token novo
                $valid_token = JWT::encode($token_options, $this->secret_key);
                //Atualiza token
                Users::where('id', $user->getAttribute('id'))->update(['token' => $valid_token]);
            }

            $json = [
                'token' => $valid_token
            ];

            return $res->withStatus(200)->withJson($json);

        } else {
            $json = [
                'code' => '401',
                'error' => "invalid username or password"
            ];
            return $res->withStatus(401)->withJson($json);
        }

    }

    public function token_validate($token, $key)
    {
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));
            return true;
        } catch (\Firebase\JWT\ExpiredException $e) {
            return false;
        }

    }

    //Insert new user
    public function user(Request $request, Response $response, $args)
    {
        $post = $request->getParams();
        $options = [
            'salt' => random_bytes(22),
        ];

        $id = $post['id'];
        $name = $post['name'];
        $username = $post['username'];
        $password = $post['password'];
        $pwd_hash = password_hash($password, PASSWORD_BCRYPT, $options);

        if ($request->isPost()) {

            //Insere o usuario novo
            $user = new Users;
            $user->makeHidden('password');
            $user->name = $name;
            $user->username = $username;
            $user->password = $pwd_hash;
            $user->save();

        } else if ($request->isPut()) {

            $data = [
                'name' => $name,
                'password' => $pwd_hash
            ];

            $user = Users::where('id', $id)->update($data);


        }


        return $response->withJson($user);
    }
}