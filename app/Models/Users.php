<?php
/**
 * Token authentication using JWT (Json Web Tokens), with configuration of public routes and routes that require authentication.
 *
 * @author Enzo Nagata <enzo.nagata@gmail.com>
 * @link      https://fb.com/enzomassaharunagata
 * @version     0.0.1
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Users extends Model
{
    protected $table = 'users';
    protected $fillable = ['id','name', 'username'];
    public $timestamps = false;
}


?>