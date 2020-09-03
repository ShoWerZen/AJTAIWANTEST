<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Google_Client;
use Exception;
use \App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function googleLogin(Request $request){
        $data = $request->all();

        if(isset($data["token"])){
            try{

                $token = $data["token"];

                \Log::info("Google Login in with token:" . $token);

                // Specify the CLIENT_ID of the app that accesses the backend
                $client = new Google_Client(['client_id' => env("GOOGLE_CLIENT_ID")]); 

                $payload = $client->verifyIdToken($token);

                if ($payload) {

                    \Log::info($payload);

                    $name = $payload['name'];
                    $email = $payload['email'];
                    $googleId = $payload['sub'];

                    $users = User::where("googleId", "=" ,$googleId)->get();

                    if(sizeof($users) == 0){ //regist new user
                        $userArray = [
                            "name" => $name,
                            "email" => $email,
                            "googleId" => $googleId,
                            "password" => Str::random(8)
                        ];

                        \Log::info($userArray);

                        User::createValidate($userArray);

                        $userArray["password"] = Hash::make($userArray["password"]);

                        $user = User::create($userArray);

                        Auth::loginUsingId($user->id);

                        return response($user, 200);
                    }
                    else{
                        Auth::loginUsingId($users[0]->id);

                        return response($users[0], 200);
                    }
                } else
                    return response(["error" => "invalid code"], 403);
            }
            catch(Exception $e){
                return response(["error" => $e->getMessage()], 500);
            }
        }
        else
            return response(["error" => "code missing"], 403);
    }
}
