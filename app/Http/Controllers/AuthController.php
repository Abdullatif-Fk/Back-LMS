<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class AuthController extends Controller
// {
//     //
// }
namespace App\Http\Controllers;

use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        error_log(print_r($request->all(), true));
        error_log($request->all()['first_name']);

        $admin = Admins::create([
            'first_name' => $request->all()['first_name'],
            'last_name' => $request->all()['last_name'],
            'email' => $request->all()['email'],
            'password' => $request->all()['password'],
        ]);

        $token = auth()->login($admin);
        error_log($token);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        // error_log(print_r($request->all(), true));

        $credentials = request(['email', 'password']);
        error_log(print_r(Auth::attempt($credentials), true));
        error_log(print_r($credentials, true));
        if (!$token = auth()->attempt($credentials)) {

            return response()->json(['error' => 'Incorrect password or username'], 401);
        } else {
            error_log(print_r($credentials, true));

            return $this->respondWithToken($token);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        error_log($token);
        error_log(print_r(auth()->user(), true));

        // $user = auth()-> user();
        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'admin' => auth()->user(),
        ]);
    }
}
