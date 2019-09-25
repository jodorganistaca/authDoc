<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Log;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(Request $request){
        try {
            
            $data = [
                'user_username' => request('user_username'),
                'user_password' => request('user_password'),
            ];
            $ldapConnection = ldap_connect('ldaprbog.unal.edu.co', 389);
            $data['user_username'] = str_replace('@unal.edu.co', '', $data['user_username']);

            Log::info($request['user_username']);
            //echo "Hello ";
            /*$app_env = $_ENV['APP_ENV'];*/

            $ldapDn  = 'uid=' . $data['user_username'] . ',ou=people,o=unal.edu.co';
            $ldapPwd = trim($data['user_password']);

            if( $answer = @ldap_bind($ldapConnection, $ldapDn, $ldapPwd) ) {
                ldap_close($ldapConnection);
                echo "Hello ";
                echo gettype($request);
                echo "<br/>";
                //echo $request;
                echo "<br/>";
                echo csrf_token(); 
                //echo strstr((string)$request, 'token');
            } else {
                return response()->json(['error' => 'Error de autenticación con LDAP'], 401);
            }
            
        } catch (\Exception $e) {
            /*Log::debug($e);*/
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function test(){
        return 'hola mundo';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
